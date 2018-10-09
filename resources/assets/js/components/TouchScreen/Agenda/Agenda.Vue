<template>

    <div class="main-content">
    <v-container grid-list-md>


        <v-layout row wrap >

            <v-flex >
                <v-card>
                    <v-tabs
                            v-model="active"
                            slider-color="black" >

                        <template v-for="(schedule,index) in schedules"
                                 >
                                <v-tab ripple>
                                    {{schedule.tab_label}}



                                </v-tab>


                                <v-tab-item v-if="schedule.type=='schedule'" class="transparent">
                                    <v-card flat class="yoyo">
                                        <h1 class="main_text">{{schedule.schedule.title}}</h1>
                                        <h3 class="main_text">{{schedule.date}}</h3>

                                        <table class="fixed_header table table-striped">

                                            <tbody class="table_body">
                                            <tr v-for="(event,index) in schedule.schedule.events">
                                                <td>{{event.title}}</td>
                                                <td>{{event.location}}</td>

                                            </tr>


                                            <h2>{{schedule.breakout.title}}</h2>

                                                <tr v-for="(breakout,index) in schedule.breakout.session_blocks" v-show="schedule.breakout.session_blocks">

                                                        <h2>{{breakout.time_range}}</h2>
                                                        <br>

                                                            <v-card v-for="(events,index) in breakout.events">

                                                                <td>{{events.title}}</td>
                                                                <td>{{events.location}}</td>



                                                            </v-card>



                                                    <v-card>

                                                    </v-card>




                                                </tr>




                                            </tbody>
                                        </table>


                                    </v-card>
                                </v-tab-item>

                                <v-tab-item v-else>
                                    <v-card flat>
                                        <h1>{{schedule.tab_label}}</h1>
                                    </v-card>
                                </v-tab-item>



                        </template>



                    </v-tabs>

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


                            <div class="drawer">
                                <nav-drawer></nav-drawer>
                            </div>

                        </v-list>


                    </v-bottom-sheet>




                </v-card>

            </v-flex>



        </v-layout>
    </v-container>


    </div>

</template>

<style>
    .drawer{
        background-color:var(bg-color);
        padding-top: -10vh;

    }



    .main-content{
        top:8vh;
        position:relative;
        background: transparent;
    }

    .fixed_header{
        width: 80vw;
        table-layout: fixed;
        border-collapse: collapse;

    }

    table tbody, .main_text{
        padding-left: 20px;
    }
    .fixed_header tbody{
        display:block;
        width: 100%;
        overflow: auto;
        height: 40vh;
    }

    .fixed_header thead tr {
        display: block;
    }

    .fixed_header thead {
        background: black;
        color:#fff;
    }

    .fixed_header th, .fixed_header td {
        padding: 5px;
        text-align: left;
        width: 85vw;
    }
</style>

<script>


    export default {


        onIdle() {
            console.log('zzzz')
            this.messageStr = 'ZZZ'
        },
        onActive() {
            console.log('zzzz')
            this.messageStr = 'Hello'
        },


        data() {


            return {
                schedules:[],
                sheet: false,


                tiles: [
                    {img: 'keep.png', title: 'Keep'},
                    {img: 'inbox.png', title: 'Inbox'},
                    {img: 'hangouts.png', title: 'Hangouts'},
                    {img: 'messenger.png', title: 'Messenger'},
                    {img: 'google.png', title: 'Google+'}
                ]
            }
        },


        beforeMount(){
            this.getSchedule();
        },

        methods:{

            getSchedule(){
                axios.get('./getSchedule')
                    .then(response => {
                        console.log(response.data);
                        this.schedules= response.data

                       // console.log(this.users);
                    });
            }
        }

    }
</script>

