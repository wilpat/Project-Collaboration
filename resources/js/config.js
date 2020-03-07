import axios from 'axios';
import router from './routes'
import store from './store/store'

export let API = '';

if (process.env.NODE_ENV === 'development') {
  API = 'http://localhost:8000/api/'
} else {
  API = 'https://collab.weokafor.com/api'
}

// console.log(API)


const blackAxios = axios.create({
  baseURL: API,
  timeout: 30000
})

blackAxios.interceptors.response.use(response => {
  return response
}, error => {
  // console.log(error.response);
  if (error.response.status == 401) {
    router.push({name: 'login', query: { redirect: router.fullPath }})
  } 
  return Promise.reject(error);
})

export {blackAxios};