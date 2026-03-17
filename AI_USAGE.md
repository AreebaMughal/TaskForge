### Declaration
During this project, I used AI as a learning and debugging companion  not as a code generator. 
The honest summary of how it worked
- I asked AI to explain one complete CRUD example so I could understand the full pattern. Form Request, Action class, thin controller, and Blade views working together
- Once I understood that pattern, I built every other module myself by following the same structure. 
- The template gave me the shape, the actual code
for each module was written by me.
- Where AI genuinely helped was in the moments I was stuck on a specific error I couldn't figure out from the error message alone things. In those cases I described the error, got an explanation of why it happens, and then fixed it.
- No final code blocks were copied without being read, understood, and adapted to this project's specific models and requirements.

## What AI Was Used For
- One CRUD Template (Starting Point)
- I asked for one complete worked example of the Clients CRUD including the Form Request, Action class, controller, and Blade views to understand how all the pieces connect. 
- I studied this example, asked questions about parts I didn't understand, and then used it as a reference pattern when building Projects, Tasks, TimeLogs, and Users myself. 
- Each subsequent module was written from scratch based on
that understanding.

## Concept Explanations
- How Laravel 12 events and listeners work and why you'd use them over just calling code directly
- How queued jobs differ from synchronous execution and why that matters for email sending
- What bootstrap/app.php does in Laravel 12 and which old files it replaces
- How route model binding connects to policy authorization automatically
- The difference between belongsTo and hasMany and when you actually need to define each side
- Why Form Requests have both authorize() and rules() and how they interact
- How sync() works for many-to-many updates vs manually detaching and re-attaching

## Debugging Guidance
- Why validateStrings does not exist happened — typo in a validation rule name produces a method-not-found exception
- Why pagination() is not a method — correct Laravel method is paginate()
- Why a space inside 'in:admin, manager' silently breaks validation — the space becomes part of the value being matched
- Why putting selected logic inside the value="" attribute causes wrong form submissions — they are separate HTML attributes
- Why two conflicting use statements for Schedule caused a non-static error in routes/console.php

## Architecture Guidance
- Where business rules belong (Actions vs Controllers) and why that separation matters for testing
- How to structure an Action class to throw exceptions that the controller can catch and show as user-facing errors

## What Was Written Manually
- All migration schemas columns, foreign keys, indexes, deletes based on the assignment data model
- All model relationships and $fillable arrays
- All policy logic including the ownership checks
- All controller method bodies for Projects, Tasks, TimeLogs, Users written after understanding the Clients example
- All action class logic, archive rules, member assignment, date validation, delete blocking
- All Blade views and Tailwind styling for every module
- All seeder data, realistic names, and distribution logic across 6 users, 5 clients, 10 projects, 30 tasks, 100 timelogs
- All 10 custom feature tests and assertions
- All route definitions
- PLAN.md written before any coding started