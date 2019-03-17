<template>


  <div class="container">




    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            You want to delete this pair
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" @click="executDelete">Delete</button>
          </div>
        </div>
      </div>
    </div>



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

            {{source_currency['id']}} - {{pairs['to_currencies'][index]['id']}}
            <router-link :to="{ path: '/edit?source=' + source_currency['id'] + '&to=' + pairs['to_currencies'][index]['id'] }">Edit</router-link>
             - <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" @click="prepareDelete(source_currency.id, pairs['to_currencies'][index].id)">
               Delete
             </button>

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
          source_delete: 0,
          to_delete: 0,

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

            prepareDelete(source, to){
              this.source_delete = source;
              this.to_delete = to;
            },

            executDelete(){
              axios.post('api/delete_pair',{
                source: this.source_delete,
                to: this.to_delete
              },{
                headers: {
                  'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
              }).then( response => {

                this.counter = 0;

                this.source_delete = 0;
                this.to_delete = 0;
                  $('#deleteModal').modal('hide');
              })
              .catch( error => {
                console.log(error.response);
                // this.errors.record(error.response.data.errors);

              })
            },




          }


    }
</script>
