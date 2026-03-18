###### Project Overview ######
- TaskForge
- Internal tool for tracking client projects, tasks, and time logs.
- Stack : laravel 12, MySQL, Blade, Breeze(auth only), Tailwind CSS, DebugMail
## Setup Instructions
1. Clone the repository
2. Install dependencies
composer install
npm install && npm run build
3. Environment setup
cp .env.example .env
php artisan key:generate
4. Configure your database
Open .env and update:
DB_DATABASE=taskforge
DB_USERNAME=root
5. Run migrations and seeders
php artisan migrate --seed
6. Start the development server
php artisan serve
7. Run the queue worker in a separate terminal:
php artisan queue:work
To manually trigger the overdue task check:
php artisan app:check-overdue-tasks
8. Mail Setup (DebugMail)
The project uses DebugMail to catch emails during development.
Sign up at https://debugmail.io
Copy your SMTP credentials into .env:
- MAIL_MAILER=smtp
- MAIL_HOST=debugmail.io
- MAIL_PORT=25
- MAIL_USERNAME=your_debugmail_username
- MAIL_PASSWORD=your_debugmail_password
- MAIL_FROM_ADDRESS=taskforge@example.com
- MAIL_FROM_NAME="TaskForge"

## Where eager loading is used:
- ClientController@show — loads projects with the client so - the show page doesn't query per project
- ProjectController@index — Project::with('client')- ->withCount('tasks') loads all client names and task - counts in 2 extra queries instead of one per row
- ProjectController@show — $project->load(['client', 'tasks.- timelogs', 'members']) loads everything the detail page - needs upfront
- TaskController@show — $task->load(['project', 'timelogs.- user']) loads the task's project and each timelog's user - in one go
- LogTimeAction — Task::with('project.members') chains two - relationships in a single query
- CheckOverdueTasks command — Task::with('project') so the - job doesn't reload the project for each task
- TaskSeeder — Project::with('members')->get() avoids a - members query per project during seeding

## Requirement Mapping
# FR-1 — Auth and Roles
Roles are stored as an enum on the users table. Three helper methods on the User model isAdmin(), isManager(), isMember(). Authorization is enforced through five Policy classes: ClientPolicy, ProjectPolicy, TaskPolicy, TimelogPolicy, and UserPolicy. No scattered if-statements in controllers.
# FR-2 — Data Model
All models and migrations live in the standard Laravel folders. Relationships cover one-to-many , many-to-many , and deletes on all main models.
# FR-3 — CRUD Flows
Each resource has a dedicated controller, two Form Requests (store and update), and where needed an Action class for business logic. Client deletion is blocked by DeleteClientAction if active projects exist. Project list supports status filtering. Member assignment uses sync() through AssignMembersAction.
# FR-4 — Business Rules
- Archive blocked by ArchiveProjectAction if any task is not completed
- Task due date validated against project start date inside CreateTaskAction
- Member project membership checked in both CreateTaskAction and LogTimeAction
- Timelog minutes capped at 600 via min:1, max:600 in StoreTimelogRequest

# ER-A — Structure
- All controllers are thin . Each method calls an Action  and returns a response. Business logic lives in Actions. All routes use Route::resource() where appropriate.
# ER-B — Validation and Security
- Every create and update operation goes through a Form Request class. All models have $fillable defined. State changing routes are behind auth middleware with @csrf in every form. Policies handle all authorization.
# ER-C — Database
- Migrations are fully reversible with down() methods. Foreign key constraints and indexes are defined where they make sense. Eager loading is used throughout.
# ER-D — Events, Jobs, Notifications
- When a project is archived, ArchiveProjectAction fires a ProjectArchived event. ProjectArchivedListener picks it up and writes a row to the audit_logs table. For overdue  tasks, a scheduled command runs daily, dispatches a NotifyOverdueTask job per overdue task, and the job sends a TaskOverdueNotification email to the project manager through the database queue driver.
# ER-E — Tests
- 10 custom feature tests covering authorization denial, business rule enforcement, validation errors, successful CRUD operations, and queued job dispatch.
# 10. Self-Review Checklist
- [x] All database columns match the naming requirements (contact_email, user_id, logged_at).
- [x] Managers can only see and manage their own clients and projects.
- [x] Members can only see tasks and timelogs for their assigned projects.
- [x] Archive read-only is enforced on the server-side for all write operations.
- [x] Task due dates are validated against project dates on both create and update.
- [x] All business logic is extracted into Action classes.
- [x] Controllers are thin and only handle request validation and action calls.
- [x] The ProjectArchived event listener is explicitly registered.
- [x] Audit logs are created when a project is archived.
- [x] Feature tests cover all critical business rules and authorization edge cases.