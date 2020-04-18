import numeral from "numeral";
Vue.component("subscribe-button", {
  props: {
    subscriptions: {
      type: Array,
      required: true,
      default: () => []
    },
    channel: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  methods: {
    toggleSubscription() {
      if (!window.Auth.user) {
        alert("PLease Login to subscribe.");
      }
    }
  },
  computed: {
    subscribe() {
      if (!__auth() || this.channel.user_id === __auth().id) return false;
      return !!this.subscriptions.find(
        subscription => subscription.user_id === __auth().id
      );
    },
    owner() {
      if (__auth() && this.channel.user_id === __auth().id) return true;

      return false;
    },
    count() {
      return numeral(this.subscriptions.length).format("0a");
    }
  }
});
