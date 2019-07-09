export default {
  methods: {
    textTruncate (str, len = 100, ending = '...') {
      console.log(str) 
      if (str.length > len) {
        return str.substring(0, len - ending.length) + ending;
      }

      return str;
    }
  }
}