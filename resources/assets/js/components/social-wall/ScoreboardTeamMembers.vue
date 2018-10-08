<template>
  <div class="scoreboard-team-member-container">

    <div class="scoreboard-team-member-widgets">
      <div>
        <team-badge
          v-bind:team-name=" teamName "
          v-bind:badge-label=" '#' + teamHashtag "
          v-bind:badge-width=" 500 "
          v-bind:badge-height=" 500 "
          v-bind:badge-background-color=" teamBackgroundColor "
          v-bind:badge-text-color=" teamTextColor "
        ></team-badge>
      </div>
      <div>
        <generate-qr-code
          qr-code-text="https://twitter.com/intent/tweet"
        ></generate-qr-code>
      </div>
    </div>

    <div class="scoreboard-team-member-team">

      <div
        class="scoreboard-team-member-teamleaders"
        v-for=" team_member in teamMembers "
        :key="team_member.id"
      >

        <span
          class="scoreboard-team-member-counter"
        >{{ team_member.counter + 1 }}.</span>

        <span
          class="scoreboard-team-member-name"
        >{{ team_member.member_name }}</span>

        <span
          class="scoreboard-team-member-points"
        >{{ team_member.points }}</span>

      </div>

    </div>

  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'teamName',
      'teamHashtag',
      'teamBackgroundColor',
      'teamTextColor',
      'scheduleFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          teamMembers: []
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      getScores: function ()
      {
        let vueInstance = this;
        axios.get(
          '/api/scoreboard/get-team-member-scores/' + vueInstance.teamName
        )
        .then(
          function ( response )
          {

            for( var i = 0 ; i < response.data.length ; i++ )
            {

              let team_member = response.data[i];

              let teamMemberStruct = {
                counter: i,
                member_name: team_member.member_name,
                points: window.NumberWithCommas( team_member.points )
              };
              
              vueInstance.$set( vueInstance.teamMembers, i, teamMemberStruct );

            }

          }
        )
        .catch(
          function ( error )
          {
            console.log( error );
          }
        )
        .then(
          function ()
          {
            vueInstance.scheduleFetch();
          }
        );
      },
      /** ------------------------------------------------------------------ **/
      scheduleFetch: function ()
      {
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.getScores();
          },
          vueInstance.scheduleFrequencyMs
        );
      }
      /** ------------------------------------------------------------------ **/
    },
    /** -------------------------------------------------------------------- **/
    created: function ()
    {
      let vueInstance = this;
    },
    /** -------------------------------------------------------------------- **/
    mounted: function ()
    {
      let vueInstance = this;
      vueInstance.getScores();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss">

  @import '~@/_opentext_branding.scss';

  .scoreboard-team-member-container
  {
    display:grid;
    grid-template-columns:20% auto;
    font-size:3vw;
    line-height:6vw;
    margin:5vh 5vw 0vh 5vw;
  }

  .scoreboard-team-member-widgets
  {
    grid-column:1;
    grid-row:1;
    margin:0vh 3vw 0vh 0vw;
  }

  .scoreboard-team-member-widgets canvas
  {
    width:100%;
    height:100%;
  }

  .scoreboard-team-member-teamleaders
  {
    grid-column:2;
    grid-row:1;
    display:grid;
    grid-template-columns:10% auto auto;
    white-space: nowrap;
    margin:0vh 0vw 3vh 0vw;
    padding:1vh 0vw 1vh 0vw;
    background-color:rgba(245,245,245,0.8);
  }

  .scoreboard-team-member-counter
  {
    grid-column:1;
    grid-row:1;
    font-weight:bold;
    display:inline-block;
    text-align:right;
    margin:0vh 0vw 0vh 4vw;
  }

  .scoreboard-team-member-name
  {
    grid-column:2;
    grid-row:1;
    display:inline-block;
    overflow-x:hidden;
    margin:0vh 0vw 0vh 4vw;
  }

  .scoreboard-team-member-points
  {
    grid-column:3;
    grid-row:1;
    font-weight:bold;
    text-align:right;
    overflow-x:hidden;
    margin:0vh 4vw 0vh 0vw;
  }

</style>
