export default function (instance) {
  return {
    signIn(payload) {
      const data = instance
        .post('login/', payload)
        .then(function (res) {
            return res
        })
      return data
    },
    signUp(payload) {
      const data = instance
        .post('register/', payload)
        .then(function (res) {
          return res
        })
      return data
    },
    logout() {
      return instance.delete('auth')
    },
  }
}
