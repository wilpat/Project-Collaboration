import axios from 'axios';

export let API = '';

if (process.env.NODE_ENV === 'development') {
  API = 'http://localhost:8000/api'
} else {
  API = 'https://collab.weokafor.com/'
}

// console.log(API)

export const blackAxios = axios.create({
  baseURL: API,
  validateStatus: function (status) {
    return status >= 200 && status < 510 // default
  },
  timeout: 30000
})