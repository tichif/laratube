<template>
  <button
    @click="toggleSubscription"
    class="btn btn-danger"
  >{{ owner ? '' : subscribe ? 'Unsubscribe' : 'Subscribe' }} {{ count }} {{ owner ? 'Subscribers' : '' }}</button>
</template>


<script>
import numeral from "numeral";
export default {
  props: {
    initialSubscriptions: {
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
  data() {
    return {
      subscriptions: this.initialSubscriptions
    };
  },
  methods: {
    toggleSubscription() {
      if (!window.Auth.user) {
        return alert("PLease Login to subscribe.");
      }

      if (this.owner) {
        return alert("You cannot subscribe your own channel");
      }

      if (this.subscribe) {
        axios
          .delete(
            `/channels/${this.channel.id}/subscriptions/${this.subscription.id}`
          )
          .then(() => {
            return (this.subscriptions = this.subscriptions.filter(
              s => s.id !== this.subscription.id
            ));
          })
          .catch(err => console.log(err));
      } else {
        axios
          .post(`/channels/${this.channel.id}/subscriptions`)
          .then(res => {
            this.subscriptions = [...this.subscriptions, res.data];
          })
          .catch(err => console.log(err));
      }
    }
  },
  computed: {
    subscribe() {
      if (!__auth() || this.channel.user_id === __auth().id) return false;
      return !!this.subscription;
    },
    owner() {
      if (__auth() && this.channel.user_id === __auth().id) return true;

      return false;
    },
    subscription() {
      if (!__auth()) return null;
      return this.subscriptions.find(
        subscription => subscription.user_id === __auth().id
      );
    },
    count() {
      return numeral(this.subscriptions.length).format("0a");
    }
  }
};
</script>