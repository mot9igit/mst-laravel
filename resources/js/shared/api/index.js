import api from './api'

export default {
  install: (app, options) => {
    app.config.globalProperties.$api = api
    app.provide('api', options)
  },
}
