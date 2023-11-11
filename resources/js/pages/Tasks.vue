<template>
  <div>
    <div class="flex flex-col w-1/2 mx-auto mt-5">
      <div class="flex flex-col w-full">
        <h1 class="text-3xl font-bold text-gray-100">
          Tasks Manager with Projects
        </h1>
        <span class="w-auto p-1 text-xs text-gray-100">
          Made with ❤️ using:
          <span class="px-1 text-red-500 bg-black rounded py-0.5">
            Laravel
          </span>
          <span class="px-1 ml-1 text-green-600 bg-black rounded py-0.5">
            Vue
          </span>
          <span class="px-1 ml-1 bg-black rounded text-cyan-500 py-0.5">
            Tailwind CSS
          </span>
          <span class="px-1 ml-1 text-blue-600 bg-black rounded py-0.5">
            Docker
          </span>
        </span>
      </div>
      <div class="flex flex-col my-2">
        <label for="project" class="mb-2 text-gray-100"> Project: </label>
        <div class="flex flex-row items-center justify-between">
          <select
            class="w-full p-2 mr-5 border border-gray-400 rounded-lg"
            name="project"
            id="project"
            v-model="selectedProjectId"
            @change="fetchTasks"
          >
            <option value="">None</option>
            <option
              v-for="project in projects"
              :key="project.id"
              :value="project.id"
            >
              {{ project.name }}
            </option>
          </select>
          <ManageProjects ref="manageProjects" @load="loadProjects" />
        </div>
      </div>
      <div class="flex flex-col my-2">
        <div class="flex flex-row items-center justify-between w-full">
          <h3 class="mb-2 text-xl font-bold text-gray-100">
            Tasks ({{ tasks.length }})
          </h3>

          <AddTask :projectId="selectedProjectId" @load="fetchTasks" />
        </div>
        <div class="flex flex-col">
          <div
            class="w-full p-2 mt-5 overflow-y-auto bg-gray-100 rounded-md h-96"
          >
            <div
              v-for="task in tasks"
              :key="task.id"
              class="flex flex-row items-center justify-between px-4 py-2 mb-2 bg-gray-800 rounded-lg"
            >
              <div class="flex flex-row items-center">
                <div class="flex flex-row justify-center w-16">
                  <button
                    class="p-1 text-white bg-gray-500 rounded-md hover:bg-green-500 bg-gradient-to-l from-gray-500 to-green-500"
                    @click="markTaskAsCompleted(task)"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                </div>
                <div class="flex flex-col w-full ml-2">
                  <div class="flex flex-row items-center">
                    <div
                      class="px-2 py-1 text-xs text-gray-100 bg-gray-700 rounded-md"
                    >
                      #{{ task.priority }}
                    </div>
                    <div
                      v-if="!task.editingName"
                      class="ml-2 text-base font-semibold text-gray-100"
                      @dblclick="selectTask(task, 'name')"
                    >
                      {{ task.name }}
                    </div>
                    <input
                      v-else
                      class="w-full px-2 ml-2 border border-gray-400 rounded-lg"
                      type="text"
                      :name="'name' + task.id"
                      :id="'name' + task.id"
                      v-model="task.name"
                      @keyup.enter="updateTask(task)"
                      @keyup.esc="selectTask(null)"
                    />
                  </div>

                  <div
                    v-if="!task.editingDescription"
                    class="my-2 text-sm text-gray-400"
                    @dblclick="selectTask(task, 'description')"
                  >
                    {{ task.description }}
                  </div>
                  <input
                    v-else
                    class="w-full p-2 mt-4 mr-2 border border-gray-400 rounded-lg"
                    :name="'description' + task.id"
                    :id="'description' + task.id"
                    v-model="task.description"
                    @keyup.enter="updateTask(task)"
                    @keyup.esc="selectTask(null)"
                  />

                  <div class="flex flex-row">
                    <div
                      v-if="task.editProject"
                      class="px-2 py-1 mt-4 text-xs text-gray-100 bg-gray-700 rounded-md"
                      @dblclick="selectTask(task, 'project')"
                    >
                      {{ task.project.name }}
                    </div>
                    <select
                      v-else-if="projects.length > 0"
                      class="w-full px-2 mt-4 border border-gray-400 rounded-lg"
                      :name="'project' + task.id"
                      :id="'project' + task.id"
                      v-model="task.project_id"
                      @change="updateTask(task)"
                      @keyup.esc="selectTask(null)"
                    >
                      <option value="">None</option>
                      <option
                        v-for="project in projects"
                        :key="project.id"
                        :value="project.id"
                      >
                        {{ project.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="flex flex-row items-center">
                <button
                  class="p-1 text-white bg-red-500 rounded-md hover:bg-red-400"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import AddTask from "../components/Tasks/Add.vue";
import ManageProjects from "../components/Projects/Manage.vue";

export default {
  components: {
    AddTask,
    ManageProjects,
  },
  data() {
    return {
      tasks: [],
      projects: [],
      selectedProjectId: "",
    };
  },
  async mounted() {
    await this.fetchTasks();
  },
  methods: {
    loadProjects(projects) {
      this.projects = projects;
    },
    async selectTask(task, field) {
      if (task) {
        task.editingName = false;
        task.editingDescription = false;
        task.editProject = false;

        switch (field) {
          case "name":
            task.editingName = true;
            break;
          case "description":
            task.editingDescription = true;
            break;
          case "project":
            task.editProject = true;
            break;
        }
      } else {
        await this.fetchTasks();
      }
    },
    async updateTask(task) {
      try {
        await axios.patch(`/api/tasks/${task.id}`, {
          name: task.name,
          description: task.description,
          project_id: task.project_id,
        });
        alert("Task updated");
        await this.fetchTasks();
      } catch (error) {
        console.error("Error updating task");
      }
    },
    async markTaskAsCompleted(task) {
      try {
        await axios.patch(`/api/tasks/${task.id}/completed`, {
          completed: true,
        });
        alert("Task marked as completed");
        await this.fetchTasks();
      } catch (error) {
        console.error("Error updating task");
      }
    },
    async fetchTasks() {
      try {
        const { data } = await axios.get(
          `/api/tasks${
            this.selectedProjectId
              ? `?project_id=${this.selectedProjectId}`
              : ""
          }`
        );
        this.tasks = data.data;
      } catch (error) {
        console.error("Error fetching tasks");
      }
    },
  },
};
</script>
