<template>
  <div v-show="$root.showModal" class="modal-backdrop">
    <div class="modal">
      <slot name="body"></slot>
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'modal',
    methods: {
      close() {
        this.$emit('close')
      },
    },
    watch: {
      '$root.showModal' : {
        handler() {
          if (this.$root.showModal) {
            document.body.classList.add("modal-open");
          } else {
            document.body.classList.remove("modal-open");
          }
        }
      }
    }
  };
</script>
