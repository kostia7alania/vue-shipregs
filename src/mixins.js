
export const mixins = {
   data() {
     return {
       notificationSystem: {
         options: { 
           show: {
             theme: 'dark',
             icon: 'icon-person',
             position: 'topCenter',
             progressBarColor: 'rgb(0, 255, 184)',
             buttons: [
               ['<button>Ok</button>', function (instance, toast) {
                 alert("Hello world!");
               }, true],
               ['<button>Close</button>', function (instance, toast) {
                 instance.hide({
                   transitionOut: 'fadeOutUp',
                   onClosing: function (instance, toast, closedBy) {
                     console.info('closedBy: ' + closedBy);
                   }
                 }, toast, 'buttonName');
               }]
             ],
             onOpening: function (instance, toast) {
               console.info('callback abriu!');
             },
             onClosing: function (instance, toast, closedBy) {
               console.info('closedBy: ' + closedBy);
             }
           },
           ballon: {
             balloon: true,
             position: 'bottomCenter'
           },
           info: {
             position: 'bottomLeft'
           },
           success: {
             position: 'bottomRight'
           },
           warning: {
             position: 'topLeft'
           },
           error: {
             position: 'topRight'
           },
           question: {
             timeout: 20000,
             close: false,
             overlay: true,
             toastOnce: true,
             id: 'question',
             zindex: 999,
             position: 'center',
             buttons: [
               ['<button><b>YES</b></button>', function (instance, toast) {
                 instance.hide({
                   transitionOut: 'fadeOut'
                 }, toast, 'button');
               }, true],
               ['<button>NO</button>', function (instance, toast) {
                 instance.hide({
                   transitionOut: 'fadeOut'
                 }, toast, 'button');
               }]
             ],
             onClosing: function (instance, toast, closedBy) {
               console.info('Closing | closedBy: ' + closedBy);
             },
             onClosed: function (instance, toast, closedBy) {
               console.info('Closed | closedBy: ' + closedBy);
             }
           }
         }
       }
     };
   },
   mounted: function () { 
    window.t = this;
    /*
     this.$toast.show('Welcome!', 'Hey', this.notificationSystem.options.show);
     this.$toast.show('Welcome!', 'Hey', this.notificationSystem.options.ballon);
     this.$toast.info('Welcome!', 'Hello', this.notificationSystem.options.info);
     this.$toast.success('Successfully inserted record!', 'OK', this.notificationSystem.options.success);
     this.$toast.warning('You forgot important data', 'Caution', this.notificationSystem.options.warning);
     this.$toast.error('Illegal operation', 'Error',  this.notificationSystem.options.error);
     this.$toast.question('Are you sure about that?', 'Hey', this.notificationSystem.options.question);
   */
  },
   methods: {},
   computed: {},
   beforeDestroy() {},
   watch: {}
 };