<template>
  <div>
    <!--
        Background CSS class:
        body { background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); }
     -->
    <div class="flex flex-col w-1/2 mx-auto mt-5">
      <div class="flex flex-row items-center justify-between">
        <h2 class="mb-4 text-2xl font-bold text-gray-100">Tasks</h2>
        <AddTask :project="selectedProject" @load="fetchTasks" />
      </div>
      <div class="flex flex-col">
        <label for="project" class="mb-2 text-gray-100"> Project: </label>
        <div class="flex flex-row items-center justify-between">
          <select
            class="w-full p-2 mr-5 border border-gray-400 rounded-lg"
            name="project"
            id="project"
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
      <!-- Form to create new task -->
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
      selectedProject: {},
    };
  },
  async mounted() {
    await this.fetchTasks();
  },
  methods: {
    loadProjects(projects) {
      this.projects = projects;
      console.log(projects);
    },
    async fetchTasks() {
      try {
        const projectId = this.selectedProject.id;
        const { data } = await axios.get(
          `/api/tasks${projectId ? `?project_id=${projectId}` : ""}`
        );
        this.tasks = data;
      } catch (error) {
        console.error("Error al cargar las tareas:", error);
      }
    },
  },
};
</script>
