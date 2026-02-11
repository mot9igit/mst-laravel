<template>
  <div class="preloader">
    <div class="preloader__content">
      <div class="preloader__loading"></div>
      <p>{{ whois[0] }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreLoader',
  props: {},
  data() {
    return {
      whois: ['Почти готово...', 'Подгружаем данные...', 'Идёт загрузка...'],
    }
  },
  methods: {
    pollPerson() {
      const first = this.whois.shift()
      this.whois = this.whois.concat(first)
    },
  },
  watch: {},
  mounted() {
    window.setInterval(() => {
      this.pollPerson()
    }, 2500)
  },
}
</script>

<style lang="scss" scoped>
.main__content-wrapper .preloader {
  position: fixed;
  border-top-left-radius: 40px;
  top: var(--header-height);
  left: var(--sidebar-width);
}

.preloader {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  background: rgba(255, 255, 255, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1003;
  -webkit-backdrop-filter: blur(22.8px);
  backdrop-filter: blur(22.8px);
  will-change: transform;
  transition-duration: 0.3s;
  &__content {
    align-items: center;
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: fixed;
    top: 50%;
    transform: translate(0%, -50%);
    p {
      font-size: 14px;
      font-weight: 400;
    }
  }
  &__loading {
    position: relative;
    color: transparent;
    min-height: 100px;
    min-width: 100%;
    &:hover {
      color: transparent;
    }
    &::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background-image: url(/images/loader.svg);
      z-index: 10;
      max-width: 95px;
      max-height: 95px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
      left: 50%;
      transform: translate(-50%, 0px);
    }
    &::after {
      position: absolute;
      left: 0;
      top: 0;
      content: '';
      width: 100%;
      height: 100%;
      z-index: 9;
    }
  }
}
</style>
