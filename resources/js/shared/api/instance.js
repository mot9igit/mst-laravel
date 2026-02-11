import axios from 'axios'

const instance = axios.create({
  baseURL: '/rest/',
  withCridentials: true,
  headers: {
    accept: 'application/json',
  },
})

export default instance
