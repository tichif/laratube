<template>
  <div class="card mt-5 p-5">
    <div v-if="auth" class="form-inline my-4 w-full">
      <input type="text" v-model="newComment" class="form-control form-control-sm w-80" />
      <button @click.prevent="addComment" class="btn btn-sm btn-primary">
        <small>Add comment</small>
      </button>
    </div>

    <comment v-for="comment in comments.data" :key="comment.id" :comment="comment"></comment>

    <div class="text-center">
      <button v-if="comments.next_page_url" @click="fetchComments" class="btn btn-success">Load more</button>
      <span v-else>No more comments</span>
    </div>
  </div>
</template>

<script>
import Comment from "./Comment";
export default {
  mounted() {
    this.fetchComments();
  },
  components: {
    Comment
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
