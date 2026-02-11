<template>
  <section class="dart_wrapper auth">
    <Toast />
    <PreLoader v-if="loading"></PreLoader>
    <form class="auth__form" @submit.prevent="formSubmit">
      <a href="/" class="auth__logo">
        <picture>
          <source media="(max-width: 1920px)" srcset="/icons/logo-1920.svg" />
          <source media="(max-width: 800px)" srcset="/icons/logo-800.svg" />
          <source media="(max-width: 640px)" srcset="/icons/logo-640.svg" />
          <source media="(max-width: 400px)" srcset="/icons/logo-400.svg" />
          <source media="(max-width: 320px)" srcset="/icons/logo-320.svg" />
          <img src="/icons/logo-1920.svg" loading="lazy" width="368" height="79" />
        </picture>
      </a>

      <!-- <div class="auth__loading">
        <canvas class="d-loader" style="width: 60px; height: 60px"></canvas>
        <p class="text">Пожалуйста, подождите,<br>идет загрузка контента</p>
      </div> -->

      <div class="d-input__group auth__fields">
        <div class="d-input__wrapper">
          <div class="d-input" :class="{ 'd-input--error': v$.form.username.$error }">
            <input
              type="text"
              placeholder="Введите логин"
              v-model="form.username"
              name="login"
              class="d-input__field"
              data-input-id="login"
            />
            <button
              v-if="this.form.username"
              type="button"
              class="d-close d-input__button d-show-alt"
              @click="clearField"
            >
              <mdicon name="close" />
            </button>
          </div>
          <div v-if="v$.form.username.$error" class="d-input-error">
            {{ console.log(v$.form.username) }}
            <i class="d-icon-warning d-input-error__icon"></i>
            <span v-if="v$.form.username.required" class="d-input-error__text"
              >Пожалуйста, введите Email или Логин.</span
            >
          </div>
        </div>
        <div class="d-input__wrapper">
          <div class="d-input" :class="{ 'd-input--error': v$.form.password.$error }">
            <input
              :type="showPassword ? 'text' : 'password'"
              placeholder="Введите пароль"
              name="password"
              class="d-input__field"
              v-model="form.password"
              data-input-id="password"
            />
            <button
              type="button"
              class="d-input__button d-show-alt"
              @click="togglePasswordVisibility"
            >
              <mdicon v-if="showPassword" name="eye-closed" />
              <mdicon v-else name="eye" />
            </button>
          </div>
          <div v-if="v$.form.password.$error" class="d-input-error">
            <i class="d-icon-warning d-input-error__icon"></i>
            <span v-if="v$.form.password.required" class="d-input-error__text"
              >Пожалуйста, введите Пароль.</span
            >
          </div>
        </div>
      </div>

      <div class="auth__buttons">
        <button class="d-button d-button-primary">Войти</button>
        <button type="button" class="d-button d-button-secondary" @click="this.setRegForm">
          Зарегистрироваться
        </button>
        <button
          type="button"
          class="d-button d-button-link"
          @click.prevent="showForgotModal = true"
        >
          Забыли пароль?
        </button>
      </div>
    </form>

    <div class="auth__footer">
      <!--
        <div class="feedback visible-800">
          <div class="feedback__content">
            <p class="feedback__title">Не получается войти в ЛК?</p>
            <p class="feedback__text">
              Свяжитесь с нами через почту
              <a href="mailto:client.ms@yandex.ru" class="inline-block link">client.ms@yandex.ru </a>
              или по номеру телефона
              <a href="tel:88003501519" class="inline-block link">+7 (800) 350-15-19 </a>
            </p>
          </div>
        </div>
      -->
      <div class="copyright visible-800">
        <span class="copyright__text">© МСТ, {{ getYear }}</span>
      </div>
    </div>

    <div class="copyright hidden-800">
      <span class="copyright__text">© МСТ, {{ getYear }}</span>
    </div>
    <!--
    <div class="feedback hidden-800">
      <div class="feedback__content">
        <p class="feedback__title">Не получается войти в ЛК?</p>
        <p class="feedback__text">
          Свяжитесь с нами через обратную связь, кликнув на кнопку, расположенную справа.
        </p>
      </div>

      <div class="feedback__button-wrapper">
        <button type="button" class="d-button d-button-primary d-button-rounded">
          <i class="d-icon-messages d-button-rounded__icon"></i>
        </button>
      </div>
    </div>
    -->
  </section>
  <!--
  <div class="d-notion">
    <div class="d-notion__left">
      <i class="d-error"></i>

      <span class="d-notion__category-name hidden-640">Ошибка</span>
      <p class="d-notion__title hidden-640">
        Отутствие подключение к интернету. Проверьте подключение к интернету и перезагрузите
        страницу.
      </p>
    </div>

    <div class="d-notion__middle visible-640">
      <span class="d-notion__category-name">Ошибка</span>
      <p class="d-notion__title">
        Отутствие подключение к интернету. Проверьте подключение к интернету и перезагрузите
        страницу.
      </p>
    </div>

    <div class="d-notion__right">
      <button
        type="button"
        class="d-button d-button-primary d-button-primary-small d-notion__button hidden-640"
      >
        Обновить
      </button>
      <button type="button" class="d-close">
        <i class="d-icon-times d-close__icon"></i>
      </button>
    </div>
  </div>

  <button class="d-dropdown__button">
    <i class="d-icon-angle-rounded-bottom d-dropdown__button-icon"></i>
  </button>
  -->
  <teleport to="body">
    <customModal v-model="showForgotModal" @cancel="cancel" class="form-forgot">
      <template v-slot:title>Восстановление пароля</template>
      <formForgot />
    </customModal>
  </teleport>
</template>
<script>
import { mapActions } from 'vuex'
import customModal from '@/shared/ui/Modal.vue'
import PreLoader from '@/shared/ui/Loader.vue'
import formForgot from './forgot.vue'
import Toast from 'primevue/toast'
import { sendMetrik } from '@/shared/model/metrika'
import { required } from '@vuelidate/validators'
import useVuelidate from '@vuelidate/core'

export default {
  name: 'SignInForm',
  emits: ['setRegForm'],
  data() {
    return {
      form: {
        username: '',
        password: '',
      },
      errors: [],
      showForgotModal: false,
      showPassword: false,
      loading: false,
    }
  },
  components: { Toast, formForgot, customModal, PreLoader },
  computed: {
    getYear() {
      return new Date().getFullYear()
    },
  },
  methods: {
    sendMetrik: sendMetrik,
    ...mapActions({
      setUser: 'user/setUser',
      getSessionUser: 'user/getSessionUser',
    }),
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword
    },
    clearField() {
      this.form.username = ''
    },
    setRegForm() {
      this.$emit('setRegForm', true)
    },
    formSubmit() {
      this.v$.$touch() // Отмечаем все поля как проверенные
      if (this.v$.$invalid) {
        const errorMessage = this.getErrorMessages()
        this.$toast.add({
          severity: 'error',
          summary: 'Ошибка',
          detail: errorMessage,
          life: 3000,
        })
        return
      }
      this.loading = true
      this.$load(
        async () => {
          const data = await this.$api.auth.signIn(this.form)
          if (data) {
            if (data === 'technical error') {
              this.$toast.add({
                severity: 'error',
                summary: 'Техническая ошибка',
                detail: 'Попробуйте позже.',
                life: 3000,
              })
              this.loading = false
              return
            }
            if (!data.data.success) {
              this.$toast.add({
                severity: 'error',
                summary: 'Вход запрещен',
                detail: data.data.message,
                life: 3000,
              })
              this.loading = false
            } else {
              this.getSessionUser()
              localStorage.setItem('user', JSON.stringify(data.data.data))
              this.$store.dispatch('user/setUser', data.data)
              this.sendMetrik('auth')
              this.$router.push({ name: 'account' })
            }
            this.loading = false
          }
        },
        (error) => {
          this.$toast.add({
            severity: 'error',
            summary: 'Произошла ошибка!',
            detail: 'Не волнуйтесь, скоро мы это поправим!',
            life: 3000,
          })
          console.log(error)
        },
      )
    },
    cancel(close) {
      close()
    },
  },
  setup() {
    return { v$: useVuelidate() }
  },
  validations() {
    return {
      form: {
        password: {
          required,
        },
        username: {
          required,
        },
      },
    }
  },
}
</script>
<style lang="scss">
.dart_wrapper {
  width: 100%;
  position: relative;
  background-color: #282828;
}
.d-input .d-input__button {
  color: #fff;
}

.d-show__icon::before {
  color: #fff;
}
.form-forgot {
  .modal-content {
    max-width: 400px;
  }
}
</style>
