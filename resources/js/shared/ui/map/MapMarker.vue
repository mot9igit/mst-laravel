<template>
  <div class="marker" @click="isClicked = !isClicked">
    <div :class="`marker__content ${!isClicked && 'small-size'}`">
      <p class="marker__text">{{ address || 'Ничего не найдено :(' }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue'

export default defineComponent({
  setup() {
    return {
      isClicked: ref(false),
    }
  },
  name: 'MapMarker',
  props: {
    address: {
      type: String,
      default: '',
    },
  },
})
</script>

<style lang="scss" scoped>
.marker {
  background: none;
  border: none;

  position: relative;
  height: 53px;
  width: 47px;

  translate: -50% -75%;
  cursor: pointer;

  &::after {
    display: none;
  }

  &::before {
    content: url('/icons/marker.svg');

    position: absolute;
    left: 0;
  }

  &:hover,
  &:active,
  &:focus {
    &::before {
      content: url('/icons/marker-active.svg');
    }
  }

  &__content {
    position: absolute;
    left: 110%;

    background-color: var(--color-red);
    border-radius: var(--border-radius-large);

    padding: 8px;
    width: max-content;
    max-width: 200px;

    transition-duration: var(--transition-duration);
    overflow: hidden;
  }

  &__text {
    font-size: 12px;
    color: var(--color-white);
    line-height: normal;
    margin: 0;
    text-align: left;
  }
}

.small-size {
  width: 0px;
  padding: 0px;

  & .marker__text {
    text-wrap: nowrap;
  }
}
</style>
