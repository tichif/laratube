Vue.component("subscribe-button", {
  props: {
    subscriptions: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  methods: {
    toggleSubscription() {
      if (!window.Auth.user) {
        alert("PLease Login to subscribe.");
      }
    }
  }
});
