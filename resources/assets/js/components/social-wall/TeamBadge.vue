<template>
  <span
    class="team-badge"
    :title=" teamName "
  >
    <canvas
      :width=" badgeWidth "
      :height=" badgeHeight "
    ></canvas>
  </span>
</template>

<script>
  export default
  {
    props: [
      'teamName',
      'badgeLabel',
      'badgeWidth',
      'badgeHeight',
      'badgeBackgroundColor',
      'badgeTextColor'
    ],
    data: function ()
    {
      return(
        {
        }
      );
    },
    watch:
    {
      teamName: function ()
      {
        let vueInstance = this;
        vueInstance.drawBadge();
      }
    },
    methods: {
      drawBadge: function ()
      {
        let vueInstance       = this;
        var canvas            = vueInstance.$el.querySelector( 'canvas' );
        var ctx               = canvas.getContext('2d');
        let canvasWidth       = canvas.width;
        let canvasHeight      = canvas.height;
        let centerPoint       = canvasWidth / 2;
        let outerCircleRadius = ( ( canvasWidth / 100 ) * 98 ) / 2;
        let innerCircleRadius = ( ( canvasWidth / 100 ) * 80 ) / 2;
        let textSize          = ( canvasWidth / 100 ) * 30;
        ctx.fillStyle         = vueInstance.badgeBackgroundColor;
        ctx.strokeStyle       = 'white';
        ctx.lineWidth         = ( canvasWidth / 100 ) * 5;
        ctx.font              = textSize + 'px "aktiv-grotesk", Helvetica, Arial, sans-serif';
        ctx.textAlign         = 'center';
        ctx.textBaseline      = 'middle';
        ctx.beginPath();
        ctx.arc( centerPoint, centerPoint, outerCircleRadius, 0, Math.PI * 2, true );
        ctx.stroke();
        ctx.fill();
        ctx.beginPath();
        ctx.arc( centerPoint, centerPoint, innerCircleRadius, 0, Math.PI * 2, true );
        ctx.stroke();
        ctx.fillStyle = vueInstance.badgeTextColor;
        ctx.fillText( vueInstance.badgeLabel, centerPoint, centerPoint );
      }
    },
    created: function ()
    {
      let vueInstance = this;
    },
    mounted: function ()
    {
      let vueInstance = this;
      vueInstance.drawBadge();
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext_branding.scss';

  .team-badge
  {
    text-align:center;
    vertical-align:middle;
    display:inline-block;
    margin-left:auto;
    margin-right:auto;
  }

</style>
