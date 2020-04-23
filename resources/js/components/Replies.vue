<template>
  <div>
    <div class="media my-3" v-for="reply in replies.data" :key="reply.id">
      <a class="mr-3" href="#">
        <avatar :username="reply.user.name" :size="30"></avatar>
      </a>
      <div class="media-body">
        <h6 class="mt-0">{{ reply.user.name }}</h6>
        <small>{{ reply.body }}</small>
        <vote :default_votes="reply.votes" :entity_owner="reply.user.id" :entity_id="reply.id"></vote>
      </div>
    </div>
    <div v-if="comment.repliesCount > 0 && replies.next_page_url" class="text-center">
      <button @click="fetchReplies" class="btn btn-info btn-sm">Load replies</button>
    </div>
  </div>
</template>

<script>
import Avatar from "vue-avatar";
export default {
  components: {
    Avatar
  },
  props: {
    comment: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  data() {
    return {
      replies: {
        data: [],
        next_page_url: `/comments/${this.comment.id}/replies`
      }
    };
  },
  methods: {
    fetchReplies() {
      axios
        .get(this.replies.next_page_url)
        .then(({ data }) => {
          this.replies = {
            ...data,
            data: [...this.replies.data, ...data.data]
          };
        })
        .catch(err => console.log(err));
    },
    addReply(reply) {
      this.replies = {
        ...this.replies,
        data: [reply, ...this.replies.data]
      };
    }
  }
};
</script>