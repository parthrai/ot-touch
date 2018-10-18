<template>
   <div class="main-content">
       <div class="col-md-3 tabs" id="dd">

         <div>
           <v-tabs
                   v-model="active"
                   slider-color="black">

                   <v-tab ripple>
                       OpenText
                   </v-tab>

                   <v-tab ripple>
                       Partners
                   </v-tab>



                   <v-tab-item>
                       <v-card flat>
                           <v-card-text>
                               <ol>
                                   <li  v-for="(stand,index) in expoStands" v-show="stand.type=='OpenText'">
                                       <a href="#">{{stand.exhibitor}}</a>
                                   </li>
                               </ol>

                           </v-card-text>
                       </v-card>
                   </v-tab-item>

                   <v-tab-item>
                       <v-card flat>
                           <v-card-text>
                               <ol>
                                   <li  v-for="(stand,index) in expoStands" v-show="stand.type=='Partner'">
                                       <a href="#">{{stand.exhibitor}}</a>
                                   </li>
                               </ol>

                           </v-card-text>
                       </v-card>
                   </v-tab-item>

           </v-tabs>
         </div>

       </div>
       <div class="col-md-9" id="ss">
           <img src="images/touchscreen/expomap.png" height="400" width="100%">
           <a href="touchscreen#/">
               <v-btn
                       color="primary"
                       dark

                       absolute
                       bottom
                       left
                       fab
               >
                   <v-icon>home</v-icon>
               </v-btn>
           </a>

           <v-bottom-sheet v-model="sheet">
               <v-btn
                       slot="activator"
                       color="purple"
                       dark
                       absolute
                       bottom
                       right
                       fab
               >
                   <v-icon>list</v-icon>
               </v-btn>

               <v-list>

                   <v-subheader>Open in</v-subheader>
                   <home></home>
               </v-list>


           </v-bottom-sheet>



       </div>



   </div>
</template>

<style>
    .main-content{
        position: relative;
        top:8vh;

    }


.tabs{
    height: 70vh;

    overflow-y: scroll;
}




</style>

<script>
    export default {
        data() {
            return {
                active: null,
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                expoStands:[]

            }
        },


        beforeMount(){
            this.getExpoStands();
        },

        methods: {
            next() {
                const active = parseInt(this.active)
                this.active = (active < 2 ? active + 1 : 0)
            },

            getExpoStands(){
                axios.get('./getExpoStands')
                    .then(response => {
                        console.log(response.data);
                        this.expoStands= response.data

                        // console.log(this.users);
                    });
            }



        }
    }
</script>