<template>
  <div id="search-result" class="wrapper">
    <div class="first-table" :style="{overflow}"> 
      <div class="my-table">
        <div class="table-content">

          <TableHeader/>

          <res-head
            v-for="el in PUBLIC_MENU"
            :key="el.title" :el="el"
            @header_click="header_click"
          /> 

        </div>
      </div>
    </div>

    <div
      class="drag-from"
      :class="{'second-table-minimized': show_draft == 'min','second-table': show_draft=='std'}"
      :style="{overflow}"
    >
      <div class="table-bordered my-table"> 
        <div class="table-content">
          <div
            @mousedown="mousedown_handler"
            @mousemove="mousemove_handler"
            @mouseup="mouseup_handler"
            @click="dblclick_handler"
            class="tr tr-th tr-th-main sections-header"
            :class="{'tr-th-main-draft': 1}"
          >
            <div>
              <b>ЧЕРНОВИКИ</b> &nbsp;
              <b-badge variant="primary">{{show_draft == 'min'?'↑':'↓'}} </b-badge>
            </div>
          </div>

          <res-head
            v-show="show_draft!='min'"
            v-for="el in DRAFT_MENU"
            :key="el.title" :el="el"
            @header_click="header_click"
            :isDraft="true"
          />

        </div>
      </div>
    </div>
  </div>
</template>

<script> 
export default {
  name: "search-result",
  components: { 
    "res-head":()=>import("./SearchResult_head"),
    "TableHeader":()=>import("./TableHeader"),
    
     },
  data() {
    return {
      show_draft: "min",
      overflow: "auto",
      over: false,
      mousedown: 0
    };
  },
  computed: {
    DRAFT_MENU() { return this.$store.getters['items/DRAFT_MENU'] },
    PUBLIC_MENU() { return this.$store.getters['items/PUBLIC_MENU'] }, 
  },
  mounted() {
    this.$nextTick(() => { 
      let resizer = (window.resizer = e => {
        let h = document.querySelector(".tr-th-main").offsetHeight;
        let d = document.querySelectorAll(".tr-th-second");
        d.forEach(e => (e.style.top = h + "px"));

        let hDraft = document.querySelector(".tr-th-main-draft").offsetHeight;
        let dDraft = document.querySelectorAll(".tr-th-second-inport");
        dDraft.forEach(e => (e.style.top = hDraft + "px"));
      });
      window.onresize = resizer;
    });
    if (!window.resizer_tm) window.resizer_tm = setTimeout(e => resizer(), 100);
  },

  methods: {
    dblclick_handler() {
      this.show_draft = this.show_draft == "min" ? "std" : "min";
    },
    mousedown_handler(e) { 
      window.m_pos = e.y;
      window.BORDER_SIZE = 33; //ширина нашего перетаскиваемого бордюра;
      if (e.offsetY < BORDER_SIZE) {
        // this.mousedown = true;
        //this.show_draft = 'custom';
      }
    },

    mousemove_handler(e) { 
      if (e.offsetY > window.BORDER_SIZE) this.mousedown = false;
      if (this.mousedown) {  
        window.e = e;
        document.querySelector(".drag-from").style.minHeight =
          window.screen.height - e.clientY - 90 + "px";
        if (!("m_pos" in window)) window.m_pos = "";
        const dy = window.m_pos - e.y;
        window.m_pos = e.y;
        var panel = document.querySelector(".drag-from");
        panel.style.height =
          parseInt(getComputedStyle(panel, "").height) + dy + "px";
      }
    },
    mouseup_handler(e) {
      this.mousedown = 0;
    },

    header_click(e) { 
      setTimeout(e => {
        this.overflow = "inherit";
        this.$nextTick(() => (this.overflow = "auto"));
      }, 100);
    },

    parseKey(key) {
      let a = typeof key == "object" ? Object.keys(key) : "";
      //   console.log("parse!!=>", key, a);
      return a;
    },
    dragstart_handler(e) {
      e.target.style.opacity = "0.4";
      e.dataTransfer.effectAllowed =
        "all"; /*разрешенные события у драговера и энтера - значения е.dataTransfer.dropEffect */
      e.dataTransfer.setData("text", 111);
      //    console.log(e.dataTransfer);
      //-> тащим иконку:
      let dragIcon = document.createElement("img");
      dragIcon.src = "./img/arrow.png";
      dragIcon.width = 100;
      e.dataTransfer.setDragImage(dragIcon, 0, 0);
    },

    dragend_handler(e, i) {  //отпускаем в нужном месте, в "е" -- исходная(нужная) нода!
      e.target.style.opacity = "1";
      //e.target.classList.remove('over');
      this.over = false;
      this.delete_over(); // убираем бордюр
      alert("перетащили -> " + i);
    },
    dragover_handler(e) {
      this.delete_over(); // убираем бордюр
      let t = e.target;
      if (t.classList.contains("tr")) {
        t.classList.add("over");
      } else if (t.parentElement.classList.contains("tr")) {
        t.parentElement.classList.add("over");
        console.log(2);
      } else if (t.parentElement.parentElement.classList.contains("tr")) {
        t.parentElement.parentElement.classList.add("over");
        console.log(3);
      } else if (
        t.parentElement.parentElement.parentElement.classList.contains("tr")
      ) {
        t.parentElement.parentElement.parentElement.classList.add("over");
        console.log(4);
      }
      e.preventDefault();
      e.dataTransfer.dropEffect = "copy"; //none, copy, link, move.
      return false;
    },
    dragenter_handler(e) {
      e.target.classList.add("over");
      this.over = true;
    },
    dragleave_handler(e) {
      e.target.classList.remove("over");
      this.over = false;
    },
    drag_handler(e) {
      let s = e.target.stopPropagation;
      if (s) s(); // See the section on the DataTransfer object.
      return false;
    },
    delete_over() {
      document
        .querySelectorAll(".over")
        .forEach(e => e.classList.remove("over"));
    }
  }
};
</script>


<style lang="scss">
.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
</style>
