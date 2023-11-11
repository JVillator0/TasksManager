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
          d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
    </button>
    <Modal
      :showModal="showModal"
      title="Add New Task"
      @close="showModal = false"
      @accept="addTask"
    >
      <div class="flex flex-col">
        <div class="w-full">
          <label for="name" class="mb-2"> Name: </label>
          <input
            class="w-full p-2 border border-gray-400 rounded-lg"
            type="text"
            name="name"
            id="name"
            v-model="task.name"
            placeholder="Task name"
          />
        </div>
        <div class="w-full mt-5">
          <label for="description" class="mb-2"> Description: </label>
          <textarea
            class="w-full p-2 border border-gray-400 rounded-lg"
            name="description"
            id="description"
            cols="30"
            rows="10"
            placeholder="Task description"
            v-model="task.description"
          ></textarea>
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
  props: {
    projectId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      showModal: false,
      task: {},
    };
  },
  methods: {
    async addTask() {
      try {
        await axios.post(`/api/tasks`, {
          ...this.task,
          project_id: this.$props.projectId,
        });

        this.showModal = false;
        this.task = {};
        this.$emit("load");

        alert("Task added successfully");
      } catch (error) {
        console.log(error);
        alert("Error adding task");
      }
    },
  },
};

</script>
