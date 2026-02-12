import axios from 'axios'

const instance = axios.create({
  baseURL: '/',
  withCridentials: true,
  headers: {
    accept: 'application/json',
  },
})

export default instance
