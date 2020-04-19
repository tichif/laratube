Vue.component("channel-uploads", {
  props: {
    channel: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  data() {
    return {
      selected: false,
      videos: [],
      progress: {},
      uploads: [],
      intervals: {}
    };
  },
  methods: {
    upload() {
      this.selected = true;
      // convert to an array
      this.videos = Array.from(this.$refs.videos.files);

      const uploaders = this.videos.map(video => {
        const form = new FormData();

        this.progress[video.name] = 0;

        form.append("video", video);
        form.append("title", video.name);

        return axios
          .post(`/channels/${this.channel.id}/videos`, form, {
            onUploadProgress: event => {
              this.progress[video.name] = Math.ceil(
                (event.loaded / event.total) * 100
              );
              this.$forceUpdate();
            }
          })
          .then(({ data }) => {
            this.uploads = [...this.uploads, data];
          })
          .catch(err => console.log(err));
      });

      axios.all(uploaders).then(() => {
        this.videos = this.uploads;

        this.videos.forEach(video => {
          // make a get request to have a new data from the server
          this.intervals[video.id] = setInterval(() => {
            axios
              .get(`/videos/${video.id}`)
              .then(({ data }) => {
                // if the conversion is done, stop the request
                if (data.percentage === 100) {
                  clearInterval(this.intervals[video.id]);
                }
                // replace the video with the newest coming from the server
                this.videos = this.videos.map(v => {
                  if (v.id === data.id) {
                    return data;
                  }
                  return v;
                });
              })
              .catch(err => console.log(err));
          }, 3000);
        });
      });
    }
  }
});
