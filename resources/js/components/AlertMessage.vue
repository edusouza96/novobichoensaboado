<template>
  <div id="alert_message">
    <notifications group="alert_message" position="top center"/>
  </div>
</template>

<script>
export default {
  props: ["title", "text", "type", "active"],
  methods: {
    show: function() {
      this.$notify({
        group: "alert_message",
        title: this.title,
        text: this.text,
        type: this.type,
      });
      this.$emit("active", null);
    }
  },
  watch:{
    active(){
      if(this.active){
        this.show();
      }
    }
  }
};
</script>
