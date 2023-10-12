import axios from "@/services/axios";

const state = {
  user: {
    firstname: null,
    lastname: null,
    email: null,
    token_type: null,
    access_token: null,
  },
  tasks: null,
};

const getters = {
  isAuthenticated: function (state: { user: any; }) {
    return !!state.user.access_token;
  },
  StateTasks: function (state: { tasks: any; }) {
    return state.tasks;
  },
  StateUser: (state: { user: any; }) => state.user,
};

const actions = {
  async Register({dispatch}: any, form: { lastname: string | Blob; firstname: string | Blob; email: string | Blob; password: string | Blob; }) {
    await axios.post('register', form)
    await dispatch('LogIn', form)
  },

  async LogIn({commit}: any, user: { get: (arg0: string) => any; }) {
    let response = await axios.post("login", user);
    await commit("setUser", response.data);
  },

  async CreateTask({ dispatch }: any, task: any) {
    await axios.post("tasks", task);
    return await dispatch("GetTasks");
  },

  async EditTask({ dispatch }: any, {task , id}: any) {
    console.log(task, id);

    await axios.put("tasks/"+id, task);
    return await dispatch("GetTasks");
  },

  async GetTasks(context : any) {
    let response = await axios.get("tasks")
    context.commit("setTasks", response.data);
  },

  async deleteTask({ dispatch }: any, id: any) {
    let response = await axios.delete("tasks/"+id)
    return await dispatch("GetTasks");
  },

  async LogOut({ commit }: any) {
    let user = {
      firstname: null,
      lastname: null,
      email: null,
      token_type: null,
      access_token: null,
    };
    commit("logout", user);
  },
};

const mutations = {
  setUser(state: { user: any; }, user: any) {
    state.user = user;
  },
  setTasks(state: { tasks: any; }, tasks: any) {
    state.tasks = tasks;
  },
  logout(state: { user: any; }, user: any) {
    state.user = user;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
