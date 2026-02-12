<template>
  <FormSignUp v-if="this.isRegForm" @setRegForm="setRegForm"></FormSignUp>
  <FormSignIn v-if="!this.isRegForm" @setRegForm="setRegForm"></FormSignIn>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import FormSignIn from './ui/sign-in.vue'
import FormSignUp from './ui/sign-up.vue'

export default {
  name: 'SignInPage',
  data() {
    return {
      organizations: [],
      isRegForm: false,
    }
  },
  components: { FormSignIn, FormSignUp },
  computed: {
    ...mapGetters({
      getUser: 'user/getUser',
    }),
  },
  methods: {
    setRegForm(state) {
      this.isRegForm = state
    },
  },
  async mounted() {
    // Во время SPA тут были выставления значений LocalStorage
  },
}
</script>
<style lang="scss"></style>
