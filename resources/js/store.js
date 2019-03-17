
import Vuex from 'vuex';


export const store = new Vuex.Store({

 state:{
   token : localStorage.getItem('token') || null
 },
 getters:{
    loggedIn(state){
      return state.token !== null;
    }
 },
 mutations:{  // syncronous
  setToken(state,token){
    state.token = token;
  }

 },
 actions:{

     login(state, credentials){
     return new Pomise((resolve, reject) => {
     axios.post('api/login',{
       email: credentials.email,
       password: credentials.password
     })
     .then( response => {
       var token = response.data.auth.original.access_token
       localStorage.setItem('token', token);
       state.commit('setToken', token);
        resolve(response)
     })
     .catch( error => {
       this.errors.record(error.response.data.errors)
       reject(error)
     })
   })


 },

   // asyncronous

    // retrieveToken(state,credentials){
    //     axios.post('api/login',{
    //       email: credentials.email,
    //       password: credentials.password
    //     }).then( response => {
    //       console.log(response.data);
    //       // state.commit('setToken',response.);
    //     })
    //     .catch( error => {
    //       console.log(error.response.data.errors);
    //       this.errors.record(error.response.data.errors);
    //
    //     });

       // state.commit('setToken',payload);
    // },

 },
 getters:{
   getToken(state){
     return state.token;
   }

 }

})
