<template>
  <vue-final-modal
    v-slot="{ params, close }"
    v-bind="$attrs"
    classes="modal-container"
    content-class="modal-content"
    @closed="closed"
    @beforeClose="beforeClose"
  >
    <span class="modal__title">
      <slot name="title"></slot>
    </span>
    <div class="modal__content">
      <slot :params="params"></slot>
    </div>
    <button class="modal__close" @click="close">
      <i class="d-icon-times-flat d-modal2__close-icon"></i>
    </button>
  </vue-final-modal>
</template>

<script>
import { VueFinalModal } from 'vue-final-modal'

export default {
  name: 'CustomModal',
  inheritAttrs: false,
  emits: ['confirm', 'cancel', 'close', 'beforeClose'],
  components: {
    VueFinalModal,
  },
  methods: {
    closed() {
      this.$emit('close')
    },
    beforeClose(e) {
      this.$emit('beforeClose', e)
    },
  },
}
</script>

<style lang="scss">
.modal-content {
  position: relative;
  display: flex;
  overflow: hidden;
  flex-direction: column;
  width: 100%;
  max-width: 700px;
  max-height: 90%;
  margin: 0 1rem;
  padding: 28px 32px 32px;
  border: 1px solid #e2e8f0;
  background: #ffffffd1;
  box-shadow: 0 4px 13.4px #00000042;
  border-radius: 12px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

::v-deep(.modal-container) {
  display: flex;
  justify-content: center;
  align-items: center;
}
::v-deep(.modal-content) {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 700px;
  max-height: 90%;
  margin: 0 1rem;
  padding: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #ffffff;
}
.modal__title {
  display: block;
  margin: 24px 2rem 0 0;
  font-size: 1.5rem;
  font-weight: 700;
  font-style: normal;
  font-weight: 600;
  font-size: 20px;
  line-height: 26px;
  letter-spacing: -0.01em;
  color: #282828;
}
.modal__content {
  flex-grow: 1;
  overflow-y: auto;
  padding: 24px 0;
}
.modal__action {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-shrink: 0;
  padding: 1rem 0 0;
  .dart-btn {
    & + .dart-btn {
      margin-left: 5px;
    }
  }
}
.modal__close {
  position: absolute;
  top: 32px;
  right: 32px;
  border: none;
  background: transparent;
  cursor: pointer;
  font-size: 11px;
  width: 16px;
  height: 16px;
  color: #282828;
}

.dark-mode div ::v-deep(.modal-content) {
  border-color: #2d3748;
  background-color: #1a202c;
}
.modal__input {
  background: -webkit-linear-gradient(
    270deg,
    rgb(255, 255, 255, 0.55) 37px,
    rgb(117, 117, 117, 0.13) 3px
  );
  background: -webkit-linear-gradient(
    270deg,
    rgba(255, 255, 255, 0.55) 37px,
    rgba(117, 117, 117, 0.13) 3px
  );
  display: block;
  width: 100%;
  border: 0.2px solid #75757575;
  border-radius: 6px;
  height: 40px;
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 106%;
  letter-spacing: 0.25px;
  color: #282828;
  padding: 11px 15px 9px 15px;
}
.modal__input::-webkit-input-placeholder,
.modal__input:-moz-placeholder,
.modal__input:-ms-input-placeholder,
.modal__input::placeholder {
  color: rgba(117, 117, 117, 1);
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 18px;
}
.vfm__overlay {
  background-color: #ffffff80;
  -webkit-backdrop-filter: blur(22.8px);
  backdrop-filter: blur(22.8px);
  will-change: transform;
  transition-duration: 0.3s;
}
.vfm__content {
  -webkit-backdrop-filter: blur(22.8px);
  backdrop-filter: blur(22.8px);
  will-change: transform;
  transition-duration: 0.3s;
}
.d-input--error .modal__input {
  border-color: #f92c0d;
}
</style>
