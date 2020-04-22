<template>
  <div class="card mt-5 p-5">
    <div v-if="auth" class="form-inline my-4 w-full">
      <input type="text" v-model="newComment" class="form-control form-control-sm w-80" />
      <button @click.prevent="addComment" class="btn btn-sm btn-primary">
        <small>Add comment</small>
      </button>
    </div>

    <div class="media my-3" v-for="comment in comments.data" :key="comment.id">
      <avatar :username="comment.user.name" :size="30" class="mr-3"></avatar>
      <div class="media-body">
        <h6 class="mt-0">{{ comment.user.name }}</h6>
        <small>{{ comment.body }}</small>

        <div class="d-flex">
          <vote
            :default_votes="comment.votes"
            :entity_owner="comment.user.id"
            :entity_id="comment.id"
          ></vote>
          <button class="btn btn-sm btn-secondary ml-2">Reply</button>
        </div>
        <replies :comment="comment"></replies>
      </div>
    </div>
    <div class="text-center">
      <button v-if="comments.next_page_url" @click="fetchComments" class="btn btn-success">Load more</button>
      <span v-else>No more comments</span>
    </div>
  </div>
</template>

<script>
import Avatar from "vue-avatar";
import Replies from "./Replies";
export default {
  mounted() {
    this.fetchComments();
  },
  components: {
    Avatar,
    Replies
  },
  props: {
    video: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  data() {
    return {
      comments: {
        data: []
      },
      newComment: ""
    };
  },
  methods: {
    fetchComments() {
      const url = this.comments.next_page_url
        ? this.comments.next_page_url
        : `/videos/${this.video.id}/comments`;
      axios
        .get(url)
        .then(({ data }) => {
          this.comments = {
            ...data,
            data: [...this.comments.data, ...data.data]
          };
        })
        .catch(err => console.log(err));
    },
    addComment() {
      if (!this.newComment) return;
      axios
        .post(`/comments/${this.video.id}`, {
          body: this.newComment
        })
        .then(({ data }) => {
          this.comments = {
            ...this.comments,
            data: [data, ...this.comments.data]
          };
          this.newComment = "";
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    auth() {
      return __auth();
    }
  }
};
</script>
