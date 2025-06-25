<!-- resources/views/tasks.blade.php -->
<meta charset="UTF-8">
<title>Task Manager</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- ✅ 样式与脚本 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
    .container {
        margin-top: 50px;
    }
</style>

<x-app-layout>
    <div x-data="taskManager()" x-init="initCalendar(); loadTasks()">
        <div class="container py-5">
            <h1 class="mb-4">📋 Task Manager</h1>

            <!-- Tabs -->
            <div class="mb-4">
                <button class="btn" :class="tab === 'task' ? 'btn-primary' : 'btn-outline-primary'" @click="tab = 'task'">Task List</button>
                <button class="btn" :class="tab === 'complete' ? 'btn-primary' : 'btn-outline-primary'" @click="tab = 'complete'">Complete</button>
            </div>

            <!-- Calendar -->
            <div id="calendar" class="my-5"></div>

            <!-- Task List -->
            <div x-show="tab === 'task'">
                <template x-if="implementing.length === 0">
                    <p class="text-muted">No tasks in progress.</p>
                </template>
                <ol class="list-group list-group-numbered mb-4" x-show="implementing.length > 0">
                    <template x-for="task in implementing" :key="task.id">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <strong x-text="task.title"></strong><br>
                                <small x-text="getTaskPeriod(task)"></small>
                                <p class="text-muted mb-0" x-text="task.description"></p>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-primary me-1" @click="editTask(task)">Edit</button>
                                <button class="btn btn-sm btn-danger" @click="deleteTask(task.id)">Delete</button>
                            </div>
                        </li>
                    </template>
                </ol>
            </div>

            <!-- Completed Tasks -->
            <div x-show="tab === 'complete'">
                <template x-if="completed.length === 0">
                    <p class="text-muted">No completed tasks.</p>
                </template>
                <ol class="list-group list-group-numbered" x-show="completed.length > 0">
                    <template x-for="task in completed" :key="task.id">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <strong x-text="task.title"></strong><br>
                                <small x-text="getTaskPeriod(task)"></small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-primary me-1" @click="editTask(task)">Edit</button>
                                <button class="btn btn-sm btn-danger" @click="deleteTask(task.id)">Delete</button>
                            </div>
                        </li>
                    </template>
                </ol>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" @keydown.escape.window="closeEditModal()">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Task</h5>
                        <button type="button" class="btn-close" @click="closeEditModal()" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateTask">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" x-model="editForm.title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" x-model="editForm.due_date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" x-model="editForm.end_date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" x-model="editForm.description"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger me-auto" @click="deleteTask(editForm.id)">Delete</button>
                                <button type="button" class="btn btn-secondary" @click="closeEditModal()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alpine.js Controller -->
        <script>
            function taskManager() {
                return {
                    tab: 'task',
                    implementing: [],
                    completed: [],
                    calendar: null,
                    calendarInitialized: false,
                    editForm: { id: null, title: '', due_date: '', end_date: '', description: '', status: '' },

                    async loadTasks() {
                        try {
                            const res = await fetch('/todos');
                            const data = await res.json();
                            this.implementing = data.filter(t => t.status !== 'done');
                            this.completed = data.filter(t => t.status === 'done');
                            this.refreshCalendarEvents();
                        } catch (e) {
                            toastr.error("Failed to load tasks");
                        }
                    },

                    initCalendar() {
                        if (this.calendarInitialized) return;
                        this.calendarInitialized = true;

                        setTimeout(() => {
                            this.calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                                initialView: 'dayGridMonth',
                                height: 'auto',
                                eventClick: info => {
                                    const task = [...this.implementing, ...this.completed].find(t => t.id == info.event.id);
                                    if (task) this.editTask(task);
                                },
                            });
                            this.calendar.render();
                            this.refreshCalendarEvents();
                        }, 0);
                    },

                    refreshCalendarEvents() {
                        if (!this.calendar) return;
                        this.calendar.removeAllEvents();

                        const events = [...this.implementing, ...this.completed].map(task => ({
                            id: task.id,
                            title: task.title,
                            start: task.due_date,
                            end: this.addOneDay(task.end_date),
                            color: task.status === 'done' ? '#198754' : '#0d6efd',
                        }));

                        console.log("📅 Adding events:", events);
                        this.calendar.addEventSource(events);
                    },

                    addOneDay(dateStr) {
                        const d = new Date(dateStr);
                        d.setDate(d.getDate() + 1);
                        return d.toISOString().split('T')[0];
                    },

getTaskPeriod(task) {
    if (!task.due_date && !task.end_date) return 'No date';
    const start = task.due_date || '???';
    const end = task.end_date || '???';
    return `${start} ~ ${end}`;
}
,


                    editTask(task) {
                        this.editForm = { ...task };
                        this.editForm.due_date = this.formatDate(task.due_date);
                        this.editForm.end_date = this.formatDate(task.end_date);

                        const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                        modal.show();
                    },

                    closeEditModal() {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
                        modal.hide();
                        this.editForm = { id: null, title: '', due_date: '', end_date: '', description: '', status: '' };
                    },

                    async updateTask() {
                        try {
                            const res = await fetch(`/todos/${this.editForm.id}`, {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify(this.editForm),
});


                            if (res.ok) {
                                toastr.success("Task updated");
                                this.closeEditModal();
                                this.loadTasks();
                            } else {
                                toastr.error("Update failed");
                            }
                        } catch (e) {
                            toastr.error("Error updating task");
                        }
                    },

                    async deleteTask(id) {
                        if (!confirm('Are you sure?')) return;
                        try {
                            const res = await fetch(`/todos/${id}`, {
    method: 'DELETE',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
});

                            if (res.ok) {
                                toastr.success("Task deleted");
                                this.loadTasks();
                            } else {
                                toastr.error("Delete failed");
                            }
                        } catch (e) {
                            toastr.error("Error deleting task");
                        }
                    },

                    formatDate(date) {
    const d = new Date(date);
    return isNaN(d) ? '' : d.toISOString().split('T')[0];
}
,
                }
            }
        </script>
    </div>
</x-app-layout>
