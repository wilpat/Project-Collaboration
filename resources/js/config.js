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

blackAxios.interceptors.request.use(function (config) {
  config.headers.Authorization =  `Bearer ${store.state.user.user.token}`;
  // console.log('Sent data: ', config);
  return config;
});

blackAxios.interceptors.response.use(response => {
  return response
}, error => {
  if(error.message !== 'Network Error'){
    if (error.response.status == 401) {
      router.push({name: 'login', query: { redirect: router.fullPath }})
    }
  }
  return Promise.reject(error);
})

export {blackAxios};