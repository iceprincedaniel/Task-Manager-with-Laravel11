<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Manager</title>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        #task-list li {
            list-style: none;
        }
        .header-glow {
            position: relative;
            z-index: 1;
        }
        .header-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at center, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 2rem;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased min-h-screen">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-16 header-glow">
                <div class="relative">
                    <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-12 border border-white/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-75"></div>
                                        <div class="relative bg-gradient-to-r from-purple-600 to-blue-600 rounded-full p-3">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"/>
                                                <path fill-rule="evenodd" d="M5 9v8a2 2 0 002 2h8a2 2 0 002-2V9H5zm8 1a1 1 0 100 2h.01a1 1 0 100-2H13zm-4 0a1 1 0 100 2h.01a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <h1 class="text-5xl font-black bg-gradient-to-r from-purple-600 via-blue-600 to-purple-600 bg-clip-text text-transparent">Task Manager</h1>
                                </div>
                                <p class="text-xl text-gray-600 font-semibold ml-16 mb-2">✨ Organize your work and boost productivity</p>
                                <p class="text-sm text-gray-500 ml-16">Keep track of all your projects and tasks in one beautiful place</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-gray-700 font-semibold">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:shadow-lg text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-white/20 hover:border-blue-200/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Total Tasks</p>
                            <p class="text-4xl font-black text-gray-900 mt-3">{{ count($tasks) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-full p-4">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-white/20 hover:border-green-200/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Completed</p>
                            <p class="text-4xl font-black text-green-600 mt-3">0</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-full p-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-white/20 hover:border-orange-200/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">In Progress</p>
                            <p class="text-4xl font-black text-orange-600 mt-3">0</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-100 to-orange-50 rounded-full p-4">
                            <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-white/20 hover:border-purple-200/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Projects</p>
                            <p class="text-4xl font-black text-purple-600 mt-3">{{ count($projects) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-full p-4">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Projects Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white">Projects</h2>
                        </div>
                        <div class="p-6">
                            <!-- Add Project Form -->
                            <form method="POST" action="{{ route('projects.store') }}" class="mb-8">
                                @csrf
                                <label class="block text-sm font-semibold text-gray-700 mb-3">New Project</label>
                                <div class="flex gap-3">
                                    <div class="flex-1 relative">
                                        <input 
                                            type="text" 
                                            name="name"
                                            placeholder="Enter project name..." 
                                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-500 focus:bg-white focus:shadow-lg transition duration-200 text-sm font-medium placeholder-gray-400"
                                            required
                                        />
                                    </div>
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition duration-200 shadow-md hover:shadow-lg active:shadow-sm whitespace-nowrap">
                                        ✨ Create
                                    </button>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </form>

                            <!-- Project Selection Dropdown -->
                            <form method="GET" class="mb-8">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Filter by Project</label>
                                <select name="project_id" onchange="this.form.submit()" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-500 focus:bg-white focus:shadow-lg transition duration-200 text-gray-900 font-medium appearance-none cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2720%22 viewBox=%220 0 20 20%22%3E%3Cpath fill=%22%236B7280%22 d=%22M6 8l4 4 4-4z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2.5rem;">
                                    <option value="">📋 All Projects ({{ count($tasks) }} tasks)</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ (isset($project_id) && $project_id==$project->id)?'selected':'' }}>{{ $project->name }} ({{ $project->tasks->count() }} tasks)</option>
                                    @endforeach
                                </select>
                            </form>

                            <!-- Projects List -->
                            <div class="space-y-2">
                                @forelse($projects as $project)
                                    <div class="p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition duration-150 {{ (isset($project_id) && $project_id==$project->id)?'bg-blue-50 border-l-4 border-blue-500':'' }}">
                                        <div class="flex items-center justify-between">
                                            <a href="?project_id={{ $project->id }}" class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900">{{ $project->name }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $project->tasks->count() }} {{ $project->tasks->count() === 1 ? 'task' : 'tasks' }}</p>
                                            </a>
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">{{ $project->tasks->count() }}</span>
                                                <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm font-medium text-gray-500">No projects yet</p>
                                        <p class="text-xs text-gray-400 mt-1">Create one using the form above</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Section -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white">
                                @if(isset($project_id) && $project_id)
                                    Tasks for {{ \App\Models\Project::find($project_id)->name ?? 'Project' }}
                                @else
                                    All Tasks
                                @endif
                            </h2>
                            <p class="text-blue-100 text-sm mt-1">{{ count($tasks) }} {{ count($tasks) === 1 ? 'task' : 'tasks' }}</p>
                        </div>
                        <div class="p-6">
                            <!-- Task Form -->
                            <form method="POST" action="{{ route('tasks.store') }}" class="mb-8 p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border-2 border-blue-100">
                                @csrf
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M10.5 1.5v8m0-8h8m0 0v8m0-8l-8 8"/></svg>
                                    Create New Task
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Task Title</label>
                                        <input 
                                            type="text" 
                                            name="name"
                                            placeholder="What needs to be done?" 
                                            class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white focus:shadow-lg transition duration-200 text-sm"
                                            required
                                        />
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Project</label>
                                            <select name="project_id" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-lg focus:outline-none focus:border-blue-500 focus:shadow-lg transition duration-200 text-sm appearance-none cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2720%27 height=%2720%27 viewBox=%220 0 20 20%22%3E%3Cpath fill=%236B7280%22 d=%22M6 8l4 4 4-4z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2.5rem;">
                                                <option value="">📋 Select Project</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                                            <select name="priority" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-lg focus:outline-none focus:border-blue-500 focus:shadow-lg transition duration-200 text-sm appearance-none cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2720%27 height=%2720%27 viewBox=%220 0 20 20%22%3E%3Cpath fill=%236B7280%22 d=%22M6 8l4 4 4-4z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2.5rem;">
                                                <option value="1">🟢 Low</option>
                                                <option value="2" selected>🟡 Medium</option>
                                                <option value="3">🔴 High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg active:shadow-sm flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Add Task
                                    </button>
                                </div>
                            </form>

                            <!-- Tasks List -->
                            <ul id="task-list" class="space-y-3">
                                @forelse($tasks as $task)
                                    <li data-id="{{ $task->id }}" class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition flex items-center justify-between group">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <input type="checkbox" class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500" />
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">{{ $task->name }}</p>
                                                @if($task->project)
                                                    <p class="text-sm text-gray-500">{{ $task->project->name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                @if($task->priority == 1) bg-green-100 text-green-800
                                                @elseif($task->priority == 2) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif
                                            ">
                                                @if($task->priority == 1) Low
                                                @elseif($task->priority == 2) Medium
                                                @else High
                                                @endif
                                            </span>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="opacity-0 group-hover:opacity-100 transition">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="p-8 text-center bg-gray-50 rounded-lg">
                                        <p class="text-gray-600 mb-2">No tasks yet</p>
                                        <p class="text-sm text-gray-500">Add a new task to get started</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-12 text-center text-sm text-gray-600">
                <p>Task Manager © 2026 • Built with Laravel & Tailwind CSS</p>
            </footer>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        new Sortable(document.getElementById('task-list'), {
            animation: 150,
            onEnd: function () {
                let order = [];
                document.querySelectorAll('#task-list li').forEach(li => order.push(li.dataset.id));
                fetch('{{ route("tasks.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ order })
                });
            }
        });
    </script>
</body>
</html>
