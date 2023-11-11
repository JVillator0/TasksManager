<template>
  <div v-if="showModal" class="modal-overlay">
    <div class="modal">
      <!-- Contenido del modal -->
      <div class="pb-2 mb-5 border-b border-gray-200 modal-header">
        <h1 class="text-xl">{{ title }}</h1>
        <button @click="closeModal">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </button>
      </div>
      <div class="modal-body">
        <slot></slot>
      </div>
      <!-- save button -->
      <div v-if="showFooter" class="flex justify-center pt-2 mt-5 border-t border-gray-200">
        <button
          class="w-1/2 px-4 py-2 text-white bg-blue-500 rounded-lg"
          @click="acceptModal"
        >
          Save
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showModal: Boolean,
    title: String,
    showFooter: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    acceptModal() {
      this.$emit("accept");
    },
  },
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
