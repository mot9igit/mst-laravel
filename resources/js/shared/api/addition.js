import router from '@/router'

export default function (instance) {
  return {
    getVendors(payload) {
      const data = instance
        .post('front_gettree/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getOurVendors(payload) {
      const data = instance
        .post('front_group/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getCatalogs(payload) {
      const data = instance
        .post('front_gettree/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getOutCatalogs(payload) {
      const data = instance
        .post('front_group/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getRegions(payload) {
      const data = instance
        .post('front_gettree/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getCities(payload) {
      const data = instance
        .post('front_gettree/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getOrganizations(payload) {
      const data = instance
        .post('front_getobjects/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
    getTags(payload) {
      const data = instance
        .post('front_group/', payload)
        .then(function (res) {
          return res
        })
        .catch(function (err) {
          // TODO: подключить компонент обработки ошибок
          // console.log(err)
          if (err.response) {
            if (err.status == 403) {
              localStorage.removeItem('user')
              router.push({ name: 'home' })
            }
          } else {
            return 'technical error'
          }
        })
      return data
    },
  }
}
