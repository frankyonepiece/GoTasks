import axios from 'axios'
import Notify from "./notify";
import store from "../store"

const request = axios.create({
  baseURL: 'http://localhost:8000/api/v1',
  withCredentials: true,
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
})


request.interceptors.request.use(request => {
    if (store.getters.StateUser.access_token) {
      const user = store.getters.StateUser;
      request.headers.Authorization = user.token_type + ' ' + user.access_token
    }
    return request;
  }, error => {
  return Promise.reject(error)
})

request.interceptors.response.use(response => {
  return response;
}, error => {
  if (error.response.status == 401) {
    store.dispatch('LogOut')
  }
  if (error.response.status === 422 && error.response.data?.errors) {
    Notify.error(Object.values(error.response.data.errors).flat().join("\n"));
  }
  return Promise.reject(error);
});

export default request
