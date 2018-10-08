<template>
  <div class="logo-container">
    <img
      class="img-responsive logo"
      :src=" logoUrl "
    >
  </div>
</template>

<script>
  export default
  {
    props: [
      'logoUrl',
    ],
    data: function ()
    {
      return(
        {
        }
      );
    },
    methods: {
    },
    created: function ()
    {
      let vueInstance = this;
    },
    mounted: function ()
    {
      let vueInstance = this;
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext_branding.scss';

  .logo-container
  {
    position:relative;
    width:90vw;
    height:80vh;
    margin-left:auto;
    margin-right:auto;
    .logo
    {
      top:40%;
      left:50%;
      width:100%;
      max-height:80vh;
      position:absolute;
      transform:translate(-50%,-50%);
      margin:0px;
    }
  }
  
</style>
