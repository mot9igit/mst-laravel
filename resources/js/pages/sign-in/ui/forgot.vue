<template>
  <div class="message d-input-error" v-if="message">
    <i class="d-icon-warning d-input-error__icon"></i
    ><span class="d-input-error__text">{{ message }}</span>
  </div>
  <form class="form-signin" @submit.prevent="forgotPass">
    <div :class="{ 'd-input--error': v$.form.email.$error }">
      <input
        type="text"
        name="username"
        class="d-input__field modal__input"
        placeholder="Логин или email"
        v-model="form.email"
      />
    </div>
    <div v-if="v$.form.email.$error" class="d-input-error">
      {{ console.log(v$.form.email) }}
      <i class="d-icon-warning d-input-error__icon"></i>
      <span v-if="v$.form.email.required" class="d-input-error__text"
        >Пожалуйста, введите Email или Логин.</span
      >
    </div>
    <div class="button-container">
      <button class="d-button d-button-primary" type="submit">Восстановить</button>
    </div>
  </form>
</template>

<script>
import { required } from '@vuelidate/validators'
import useVuelidate from '@vuelidate/core'

export default {
  name: 'formForgot',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      message: '',
    }
  },
  methods: {
    forgotPass() {
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
      this.$load(async () => {
        const data = await this.$api.auth.signIn({
          username: this.form.email,
          password: this.form.password,
        })
        this.message = data.data.message
      })
    },
  },
  watch: {
    'form.email'() {
      this.message = ''
    },
  },
  setup() {
    return { v$: useVuelidate() }
  },
  validations() {
    return {
      form: {
        email: {
          required,
        },
      },
    }
  },
}
</script>

<style lang="scss" scoped>
.form-signin {
  .button-container {
    text-align: center;
    .d-button {
      box-shadow: none;
      padding: 0 16px;
      display: inline-block;
      width: auto;
    }
  }
}
.message .d-input-error__text,
.message .d-input-error__icon {
  font-size: 16px;
  margin-bottom: 5px;
}
.message .d-input-error {
  width: 100%;
}
.message .d-input-error__icon {
  margin-top: 4px;
}
.d-button {
  margin: 30px auto 0px;
}
</style>
