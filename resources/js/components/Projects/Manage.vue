<template>
  <div>
    <button
      class="px-4 py-2 text-white bg-gray-800 rounded-lg hover:bg-gray-700"
      @click="showModal = true"
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
          d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"
        />
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
        />
      </svg>
    </button>
    <Modal
      :showModal="showModal"
      :showFooter="false"
      title="Manage Projects"
      @close="showModal = false"
    >
      <div class="flex flex-row items-center justify-between w-full">
        <input
          class="w-full p-2 mr-2 border border-gray-400 rounded-lg"
          type="text"
          name="name"
          id="name"
          v-model="project.name"
          placeholder="Project name"
        />
        <button
          @click="addProject"
          class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-400"
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
              d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </button>
      </div>
      <div class="flex flex-col w-full mt-5">
        <span class="mb-2 text-xl">Projects</span>
        <span v-if="projects.length === 0" class="text-sm text-gray-400">
          No projects found
        </span>
        <span v-else class="text-xs text-gray-400">
          Double click to edit, press enter to save or esc to cancel
        </span>
        <div class="w-full p-2 mt-5 overflow-y-auto bg-gray-100 rounded-md h-80">
          <div
            v-for="project in projects"
            :key="project.id"
            class="flex flex-row items-center justify-between w-full p-1 mb-4 bg-white border-2 border-gray-200 rounded-md shadow-md"
          >
            <h2
              v-if="!project.editing"
              class="w-full pl-3 mr-2 text-sm font-semibold cursor-pointer"
              @dblclick="selectProject(project)"
            >
              {{ project.name }} <span class="text-xs text-gray-400">({{ project.tasks_count }})</span>
            </h2>
            <input
              v-else
              class="w-full p-2 pl-3 mr-2 border border-gray-400 rounded-lg"
              type="text"
              :name="'name' + project.id"
              :id="'name' + project.id"
              v-model="project.name"
              placeholder="Project name"
              @keyup.enter="update(project)"
              @keydown.esc="selectProject(null)"
            />
            <button
              @click="removeProject(project.id)"
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
    </Modal>
  </div>
</template>

<script>
import axios from "axios";
import Modal from "../Modal.vue";

export default {
  components: {
    Modal,
  },
  data() {
    return {
      showModal: false,
      project: {},
      projects: [],
    };
  },
  async mounted() {
    await this.fetchProjects();
  },
  methods: {
    async selectProject(project) {
      if (project) {
        project.editing = true;
      } else {
        await this.fetchProjects();
      }
    },
    async fetchProjects() {
      try {
        const { data } = await axios.get("/api/projects");
        this.projects = data.data;
        this.$emit("load", this.projects);
      } catch (error) {
        console.error("Error fetching projects");
      }
    },
    async addProject() {
      try {
        await axios.post(`/api/projects`, {
          ...this.project,
        });

        this.project = {};
        await this.fetchProjects();

        // alert("Project added");
      } catch (error) {
        console.log(error);
        alert("Error adding project");
      }
    },
    async update(project) {
      try {
        await axios.put(`/api/projects/${project.id}`, {
          ...project,
        });

        await this.fetchProjects();

        alert("Project updated");
      } catch (error) {
        console.log(error);
        alert("Error updating project");
      }
    },
    async removeProject(id) {
      try {
        await axios.delete(`/api/projects/${id}`);

        await this.fetchProjects();

        alert("Project removed");
      } catch (error) {
        console.log(error);
        alert("Error removing project");
      }
    },
  },
};
</script>
