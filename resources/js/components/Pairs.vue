<template>


  <div class="container">


    <div>
      {{counter}}
    </div>

    <router-link :to="{ path: 'add'}">New Pair</router-link>
    
    <table class="table" v-if="pairs.hasOwnProperty('source_currencies')">
      <thead>
        <tr>
          <th>Currency 1</th>
          <th>Currency 2</th>
          <th>Rate</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(source_currency, index) in pairs.source_currencies">
          <td>{{source_currency['short_name']}}</td>
          <td>{{pairs['to_currencies'][index]['short_name']}}</td>
          <td>{{pairs['rates'][source_currency['short_name']+pairs['to_currencies'][index]['short_name']]}}</td>
          <td>
            {{source_currency['id']}} - {{pairs['to_currencies'][index]['id']}}

            Edit - Delete

          </td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>

// import router from '../routes';

const axios = require('axios');


 class Errors  {
   constructor(){
     this.errors = {}
   }

   get(field) {
     if (this.errors[field])
      return this.errors[field][0]
   }

   record(errors) {
      this.errors = errors
    }

    has(field){
        return this.errors.hasOwnProperty(field) ;
    }

    clear(field) {
      // console.log(field);

        delete this.errors[field];
    }
 }

    export default {
      name: 'pairs',

      data(){
        return {
          counter:3,
          pairs: [],
          errors: new Errors,
        }
      },

          mounted (){
            this.getPairs();
            setInterval(()=>{this.count()}, 1000);
          },
          methods:{

            count(){
              this.counter--;
              if(this.counter < 0){
                this.getPairs();
                this.counter = 3;
              }
            },

            getPairs(){
              axios.get('api/get_rates',{
                  headers: {
                    'Authorization': 'Bearer '+localStorage.getItem('token'),
                  }
                }).then( response => {
                this.pairs = response.data;
              })
              .catch( error => {
                console.log(error.response);

              })
            },



          }


    }
</script>
