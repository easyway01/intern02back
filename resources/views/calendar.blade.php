<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar + To-Do List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 样式库 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- 脚本库 -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <style>
        .task-complete {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container mt-5" x-data="calendarTodoApp()" x-init="initCalendar">
    <h2 class="mb-4">Calendar + To-Do List</h2>

    <!-- 添加任务表单 -->
    <form @submit.prevent="addTodo" class="row g-3 mb-4">
    <div class="col-md-5">
        <input type="text" id="datepicker" class="form-control" placeholder="Add Task" x-model="newTodo" required>
    </div>
    <div class="col-md-4">
        <input type="date" class="form-control" x-model="newDate" required>
    </div>
    <div class="col-md-3">
        <select class="form-control" x-model="newDurationType" required>
            <option value="">Quickly select a time range</option>
            <option value="day">Day</option>
            <option value="week">Week</option>
            <option value="month">Month</option>
            <option value="custom">Select time range (days)</option> <!-- 新增选项 -->
        </select>
    </div>

    <!-- 新增的天数输入框，当选择“Select time range (days)”时显示 -->
    <div class="col-md-3" x-show="newDurationType === 'custom'">
    <input type="number" class="form-control" placeholder="Enter number of days" x-model="newCustomDays" min="1">
    </div>

    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
            <span x-show="!loading">Add Task</span>
            <span x-show="loading">Processing...</span>
        </button>
    </div>
</form>


    <!-- 日历显示 -->
    <div id="calendar"></div>
</div>

<script>
    $(function() {
    $("#datepicker").datepicker({
        dateFormat: "yy/mm/dd"
    });
});

    
flatpickr("#datepicker", {
        dateFormat: "Y/m/d",  // 格式：yyyy/mm/dd
        locale: "en"
    });

function calendarTodoApp() {
    return {
        newTodo: '',
        newDate: '',
        newDurationType: '',
        newCustomDays: '', // ← 添加这一行
        calendar: null,
        loading: false,

        initCalendar() {
    this.calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: '/todos',

        dateClick: (info) => {
            this.newDate = info.dateStr;
        },

        eventClick: (info) => this.handleEventClick(info),

        // ✅ 添加的内容：自定义 listWeek 的事件显示
        eventContent: function(arg) {
    const { description, status } = arg.event.extendedProps;
    return {
        html: `
            <div>
                <strong>${arg.event.title}</strong><br>
                ${description ? `<small>${description}</small><br>` : ''}
                ${status ? `<span class="badge bg-info">${status}</span><br>` : ''}
                <small>${arg.event.start.toLocaleDateString()} - ${arg.event.end?.toLocaleDateString() || ''}</small>
            </div>
                `
            };
        }
    });

    this.calendar.render();
}
,

        async handleEventClick(info) {
            const action = prompt('Enter "e" to Edit, "d" to Delete, or Cancel:');

            if (action === 'd') {
                if (!confirm('Confirm deletion of this task?')) return;

                try {
                    const res = await fetch(`/todos/${info.event.id}`, {
                        method: 'DELETE',
                        headers: this.csrfHeaders()
                    });

                    if (res.ok) {
                        info.event.remove();
                        toastr.success('Task deleted');
                    } else {
                        toastr.error('Failed to delete task');
                    }
                } catch (error) {
                    console.error(error);
                    toastr.error('Network error, deletion failed');
                }

            } else if (action === 'e') {
                const newTitle = prompt('Enter a new task name:', info.event.title);
                if (!newTitle) return;

                try {
                    const res = await fetch(`/todos/${info.event.id}`, {
                        method: 'PUT',
                        headers: { ...this.csrfHeaders(), 'Content-Type': 'application/json' },
                        body: JSON.stringify({ title: newTitle })
                    });

                    if (res.ok) {
                        info.event.setProp('title', newTitle);
                        toastr.success('Task updated');
                    } else {
                        toastr.error('Failed to update task');
                    }
                } catch (error) {
                    console.error(error);
                    toastr.error('Network error, update failed');
                }
            }
        },

        async addTodo() {
    if (!this.newTodo.trim() || !this.newDate || !this.newDurationType) {
        toastr.warning('Please fill in all fields');
        return;
    }

    this.loading = true;

    let endDate;

    if (this.newDurationType === 'custom') {
    const days = parseInt(this.newCustomDays);
    if (!days || days < 1) {
        toastr.warning('Please enter a valid number of days');
        this.loading = false;
        return;
    }
    endDate = this.calculateEndDateFromDays(days);
} else {
    endDate = this.calculateEndDate();
}


    try {
        const res = await fetch('/todos', {
            method: 'POST',
            headers: { ...this.csrfHeaders(), 'Content-Type': 'application/json' },
            body: JSON.stringify({
                title: this.newTodo,
                due_date: this.newDate,
                end_date: endDate
            })
        });

        const data = await res.json();

        if (res.ok) {
            this.calendar.addEvent({
                id: data.id,
                title: data.title,
                start: data.due_date,
                end: data.end_date,
                allDay: true
            });
            toastr.success('Task added');
            this.resetForm();
        } else {
            toastr.error(data.message || 'Failed to add task');
        }

    } catch (error) {
        console.error(error);
        toastr.error('Network error, task not added');
    } finally {
        this.loading = false;
    }
},

// 新增方法：根据输入的天数计算结束日期
calculateEndDateFromDays(days) {
    if (!days || isNaN(days)) return this.newDate; // 安全防护

    const startDate = new Date(this.newDate);
    const endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + parseInt(days)); // 不减1，加完就是 exclusive
    return endDate.toISOString().split('T')[0];
}
,


        calculateEndDate() {
            let endDate = new Date(this.newDate);
            switch (this.newDurationType) {
                case 'week':
                    endDate.setDate(endDate.getDate() + 6);
                    break;
                case 'month':
                    endDate.setDate(endDate.getDate() + 29);
                    break;
            }
            endDate.setDate(endDate.getDate() + 1); // FullCalendar 的 end 是“非包含”
            return endDate.toISOString().split('T')[0];
        },

        resetForm() {
            this.newTodo = '';
            this.newDate = '';
            this.newDurationType = '';
            this.newCustomDays = ''; // ← 加上这一行
        },

        csrfHeaders() {
            return {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            };
        }
    };
}
</script>

</body>
</html>
