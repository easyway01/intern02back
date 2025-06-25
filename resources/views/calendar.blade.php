<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* 放大整个月视图格子高度 */
    .fc-daygrid-day-frame {
        min-height: 110px;
    }

    /* 调整事件外观 */
    .fc-event {
        font-size: 1rem !important;
        line-height: 1.5;
        padding: 8px;
        border-radius: 8px;
        background-color: #0d6efd;
        color: #fff;
        border: none;
    }

    .fc-event-title {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .fc-event-time {
        white-space: normal !important;
        font-size: 0.95rem;
    }

    /* 鼠标悬停效果 */
    .fc-event:hover {
        background-color: #084298;
        cursor: pointer;
    }
</style>


<x-app-layout>
<div class="container" style="margin-top: 100px;" x-data="calendarTodoApp()" x-init="initCalendar">
    <!-- 切换视图按钮 -->
    <div class="mb-3 text-end">
        <button class="btn btn-secondary" @click="showForm = !showForm">
            <template x-if="showForm">Hide Task Form</template>
            <template x-if="!showForm">Show Task Form</template>
        </button>
    </div>

    <!-- 添加任务表单 -->
    <form x-show="showForm" x-transition @submit.prevent="addTodo" class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <label for="task-name" class="form-label">Task Name</label>
            <input type="text" id="task-name" class="form-control" placeholder="Enter task name" x-model="newTodo" required>
        </div>
        <div class="col-md-4">
            <label for="start-date" class="form-label">Start Date</label>
            <input type="text" id="start-date" class="form-control" placeholder="Select start date" x-model="newStartDate" required>
        </div>
        <div class="col-md-4">
            <label for="end-date" class="form-label">End Date</label>
            <input type="text" id="end-date" class="form-control" placeholder="Select end date" x-model="newEndDate" required>
        </div>

        <div class="col-md-8">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea class="form-control" id="description" placeholder="Enter description" x-model="newDescription"></textarea>
        </div>
        <div class="col-md-3 col-6">
            <label class="form-label invisible">Add</label>
            <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                <template x-if="!loading"><span>Add Task</span></template>
                <template x-if="loading"><span>Processing...</span></template>
            </button>
        </div>
    </form>

    <!-- 日历显示 -->
    <div id="calendar" class="my-5"></div>
</div>

<script>
    function calendarTodoApp() {
        return {
            newTodo: '',
            newStartDate: '',
            newEndDate: '', 
            newDescription: '',
            calendar: null,
            loading: false,
            showForm: true,
            startPicker: null,
            endPicker: null,
            newDate: '',

            initCalendar() {
                this.startPicker = flatpickr("#start-date", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                    onChange: (selectedDates, dateStr) => this.newStartDate = dateStr
                });

                this.endPicker = flatpickr("#end-date", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                    onChange: (selectedDates, dateStr) => this.newEndDate = dateStr
                });

                this.calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    customButtons: {
                        myToday: {
                            text: 'Today',
                            click: () => {
                                const todayStr = new Date().toISOString().split('T')[0];
                                this.calendar.today();
                                this.newDate = todayStr;
                                if (this.startPicker) this.startPicker.setDate(todayStr);
                                if (this.endPicker) this.endPicker.setDate(todayStr);
                            }
                        }
                    },
                    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    events: '/events', // ✅ 自动加载数据库中的任务
    eventClick: (info) => this.handleEventClick(info),
    eventContent: function(info) {
        const title = info.event.title;
        const desc = info.event.extendedProps.description || '';
        const start = new Date(info.event.start).toLocaleString('en-GB', {
            year: 'numeric', month: 'short', day: 'numeric',
            hour: '2-digit', minute: '2-digit',
            hour12: false
        });
        const end = info.event.end
            ? new Date(info.event.end).toLocaleString('en-GB', {
                year: 'numeric', month: 'short', day: 'numeric',
                hour: '2-digit', minute: '2-digit',
                hour12: false
            }) : '';
        const timeRange = end ? `${start} - ${end}` : start;
        return {
            html: `
                <div style="font-weight: bold;">${title}</div>
                <div style="font-size: 0.9rem;">${timeRange}</div>
                <div style="font-size: 0.8rem; color: #eee;">${desc}</div>
            `
        };
    }
});

                this.calendar.render();
            },

            async handleEventClick(info) {
                const action = prompt('Enter "e" to Edit Task, "d" to Delete Task, or Cancel:');
                if (action === 'd') {
                    if (!window.confirm(`Delete task "${info.event.title}"? This cannot be undone.`)) return;

                    try {
                        const res = await fetch(`/todos/${info.event.id}`, {
                            method: 'DELETE',
                            headers: this.csrfHeaders()
                        });

                        if (res.ok) {
                            info.event.remove();
                            toastr.success('Task deleted');
                        } else {
                            const err = await res.json().catch(() => null);
                            toastr.error(err?.message || 'Failed to delete task');
                        }
                    } catch (error) {
                        toastr.error('Network error, deletion failed');
                    }
                } else if (action === 'e') {
                    const pad = (num) => String(num).padStart(2, '0');
                    const toInputFormat = (dateObj) => {
                        const yyyy = dateObj.getFullYear();
                        const mm = pad(dateObj.getMonth() + 1);
                        const dd = pad(dateObj.getDate());
                        const hh = pad(dateObj.getHours());
                        const min = pad(dateObj.getMinutes());
                        return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
                    };

                    const fields = {
                        title: prompt('Enter new task name:', info.event.title),
                        start: prompt('New start (YYYY-MM-DDTHH:mm):', toInputFormat(new Date(info.event.start))),
                        end: prompt('New end (YYYY-MM-DDTHH:mm):', toInputFormat(info.event.end ? new Date(info.event.end) : new Date(info.event.start.getTime() + 3600000))),
                        desc: prompt('Enter new description:', info.event.extendedProps.description || '')
                    };

                    if (!fields.title || !fields.start || !fields.end || isNaN(Date.parse(fields.start)) || isNaN(Date.parse(fields.end))) {
                        toastr.warning('Invalid input');
                        return;
                    }

                    try {
                        const res = await fetch(`/todos/${info.event.id}`, {
                            method: 'PUT',
                            headers: { ...this.csrfHeaders(), 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                title: fields.title,
                                due_date: fields.start,
                                end_date: fields.end,
                                description: fields.desc
                            })
                        });

                        if (res.ok) {
                            info.event.setProp('title', fields.title);
                            info.event.setStart(fields.start);
                            info.event.setEnd(fields.end);
                            info.event.setExtendedProp('description', fields.desc);
                            toastr.success('Task updated');
                        } else {
                            toastr.error('Failed to update task');
                        }
                    } catch (error) {
                        toastr.error('Network error, update failed');
                    }
                }
            },

            async addTodo() {
                if (this.newTodo.length > 100) {
                    toastr.warning('Task title too long');
                    return;
                }

                this.loading = true;

                try {
                    const res = await fetch('/todos', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            title: this.newTodo,
                            due_date: this.newStartDate,
                            end_date: this.newEndDate,
                            description: this.newDescription || ''
                        })
                    });

                    const data = await res.json();

                    if (res.ok) {
                        this.calendar.addEvent({
                            id: data.todo.id,
                            title: data.todo.title,
                            start: data.todo.due_date,
                            end: data.todo.end_date,
                            allDay: false
                        });
                        this.resetForm();
                        this.calendar.gotoDate(this.newStartDate);
                        toastr.success('Task added');
                            this.calendar.refetchEvents();

                    } else {
                        toastr.error(data.message || 'Failed to add task');
                    }
                } catch (error) {
                    toastr.error('Network error, task not added');
                } finally {
                    this.loading = false;
                }
            },

            resetForm() {
                this.newTodo = '';
                this.newStartDate = '';
                this.newEndDate = '';
                this.newDescription = '';
                this.$nextTick(() => {
                    if (this.startPicker) this.startPicker.clear();
                    if (this.endPicker) this.endPicker.clear();
                    document.getElementById("task-name").focus();
                });
            },

            csrfHeaders() {
                return {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                };
            }
        };
    }
</script>
</x-app-layout>
