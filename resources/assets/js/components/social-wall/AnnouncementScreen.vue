<template>
  <div
    class="announcement-container"
  >
    <img
      class="img-fluid image"
      v-bind:src="imageUrl"
    >
  </div>
</template>

<script>
  export default
  {
    props: [
      'imageUrl'
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

  .announcement-container
  {
    width:100%;
    height:100%;
  }

  .image
  {
    display:block;
    margin:auto auto auto auto;
  }

</style>
