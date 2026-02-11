import router from '@/router'

export default {
  install: (app, options) => {
    app.config.globalProperties.$load = async (action, errHandler) => {
      try {
        await action()
      } catch (error) {
        if (error?.response?.status === 403) {
          localStorage.removeItem('user')
          router.push({ name: 'main' })
        } else {
          if (errHandler) {
            errHandler(error)
          } else {
            console.log(error)
          }
        }
      }
    }
    app.provide('load', options)
  },
}
