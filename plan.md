###### Project Overview ######
- TaskForge
- Internal tool for tracking client projects, tasks, and time logs.
- Stack : laravel 12, MySQL, Blade, Breeze(auth only)

#### Execution plan
 Day 1 → Migrations + Models
 Day 2 → Auth + Roles + Policies
 Day 3 → Clients
 Day 4 → Projects + Assignment
 Day 5 → Tasks + TimeLogs
 Day 6 → Events + Jobs + Notifications
 Day 7 → Tests + Cleanup + README

### FR-1 Role Design 
- Admin -> users(CRUD) + roles(Admin/Manager/Member)
|
- Manager -> projects(CRUD) + clients(CRUD) 
|
| Managers can assign members to a project(many to many, pivot table)
| project list by active or unactive status, archive action sets project to read-only
| doesn't delete client if it has active project
|
- Member -> tasks(CRUD) + time logs(CUD)
|
| task list show status, due date, total logged minutes
| minutes will be positive and capped (<= 600 per entry)
|

### FR-2 Database Design
- users(id, name, email, role, created_at, updated_at, deleted_at)
- clients(id, name, email, created_at, updated_at, deleted_at, created_by_user)
- projects(client_id, created_by_user, id, name, status, due_date, start_date, archived_at, created_at, updated_at, deleted_at)
- tasks(project_id, id, title, description, status, due_date, created_at updated_at, deleted_at, created_by_user)
- timelogs(task_id, created_by_user, id, minutes, logged_at, note, created_at, updated_at, deleted_at)
- project_user(project_id, user_id, id)

 users --- 1 to M ----> clients --- 1 to M ----> projects --- 1 to M ----> tasks
 users --- 1 to M ----> tasks --- 1 to 1 ----> timelogs
 users --- M to M (pivot) ----> projects
