<template>
  <div class="main-im">
    <div class="shops">
      <div class="header">历史店铺列表</div>
      <div class="box">
        <template v-for="(value, index) in shopList">
          <div
            class="item"
            :class="{hover: curr === index}"
            :key="index"
            v-on:click="changeShop(index)"
          >
            <div class="avatar">
              <div class="name">店</div>
            </div>
            <div class="text">
              <h4 class="name">{{value.name}}</h4>
              <div class="last">{{value.last}}</div>
            </div>
          </div>
        </template>
      </div>
    </div>
    <div class="wrapper">
      <div class="nochange" v-if="curr === null">请先选择聊天对象！
        <div class="mark"></div>
      </div>

      <div class="header">
        <div class="title">{{active.name}}</div>
        <div class="close">×</div>
      </div>
      <div class="center">
        <div class="row time">17:01</div>

        <div class="row log-my">
          <div class="avatar">
            <div class="name">我</div>
          </div>
          <div class="message">请先选择聊天对象！请先选择聊天对象！请先选择聊天对象！</div>
        </div>

        <div class="row log">
          <div class="avatar">
            <div class="name">店</div>
          </div>
          <div class="message">请先选择聊天对象！请先选择聊天对象！</div>
        </div>
      </div>
      <div class="footer">
        <div class="chatinput">
          <textarea
            class="textarea"
            placeholder="请输入内容"
            v-model="message"
            :disabled="this.curr === null"
          ></textarea>
        </div>
        <div class="tools">
          <button class="send" :disabled="this.curr === null" v-on:click="send">发送 Enter</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "im",
  data() {
    return {
      curr: 1,
      message: "",
      shopList: [
        {
          id: 12,
          name: "天天外卖水果店",
          last: "尽快整理好你所有的账单、收据、发票和开支，并记好账目明"
        },
        {
          id: 11,
          name: "我旅游想你",
          last: "尽快整理好你所有的账单、收据、发票和开支，并记好账目明"
        }
      ]
    };
  },
  computed: {
    active() {
      if (this.curr === null) {
        return {
          id: -1,
          name: "请选择店铺",
          last: ""
        };
      }
      return this.shopList[this.curr];
    }
  },
  methods: {
    send() {
      let message = JSON.parse(JSON.stringify(this.message));
      this.message = "";
    },
    changeShop(index) {
      this.curr = index;
    }
  }
};
</script>

<style lang="less" scoped>
.main-im {
  cursor: default;
  position: fixed;
  z-index: 100;
  right: 7px;
  bottom: 7px;
  max-width: 680px !important;
  height: 460px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
  .shops {
    width: 190px;
    height: 460px;
    background: #f3f6fb;
    display: block;
    .header {
      height: 49px;
      font-size: 16px;
      color: #262626;
      line-height: 16px;
      padding: 17px 0 16px 22px;
      font-weight: 700;
      border-bottom: 1px #ededed solid;
    }
    .box {
      height: 403px;
      width: 190px;
      overflow-y: auto;
      overflow-x: hidden;
      &::-webkit-scrollbar {
        width: 6px;
      }
      &::-webkit-scrollbar-thumb {
        background: #ededed;
      }
      &::-webkit-scrollbar-track {
        background: #fff;
      }
      .item {
        width: 190px;
        height: 64px;
        overflow: hidden;
        cursor: pointer;
        -webkit-transition: background-color 0.3s;
        transition: background-color 0.3s;
        &:hover {
          background-color: #fff;
        }
        &.hover {
          background-color: #fff;
        }
        .avatar {
          position: relative;
          overflow: hidden;
          width: 69px;
          height: 64px;
          float: left;
          .name {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 12px 13px 12px 16px;
            background-color: aquamarine;
            text-align: center;
            line-height: 40px;
            color: #fff;
          }

          &::after {
            display: table;
            clear: both;
            content: "";
          }
        }
        .text {
          float: left;
          width: 96px;
          padding-top: 15px;
          .name {
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 96px;
            overflow: hidden;
            cursor: pointer;
            font-size: 14px;
            color: #595959;
            margin-bottom: 0;
            margin: 0 auto;
            border: none;
            font-weight: normal;
          }
          .last {
            font-size: 12px;
            color: #8c8c8c;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 96px;
            overflow: hidden;
          }
        }
      }
    }
  }
  .wrapper {
    width: 490px;
    height: 460px;
    position: relative;
    .header {
      border-radius: 8px 8px 0 0;
      padding: 0 21px;
      height: 49px;
      border-bottom: 1px solid #ededed;
      line-height: 49px;
      .title {
        display: block;
        float: left;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        font-weight: 700;
        font-style: normal;
        font-size: 16px;
        color: #262626;
        width: 392px;
      }
      .close {
        width: 56px;
        float: left;
        text-align: right;
        color: #595959;
        font-size: 14px;
      }
    }
    .center {
      height: 320px;
      padding: 20px;
      overflow: auto;
      overflow-x: hidden;
      position: relative;
      .row {
        position: relative;
        -webkit-animation: tap-data-v-15bacdf8 0.4s 1;
        animation: tap-data-v-15bacdf8 0.4s 1;
        will-change: animation;
        padding-top: 20px;
        &::after {
          clear: both;
          display: table;
          content: "";
        }
        font-size: 12px;
        .avatar {
          position: relative;
          overflow: hidden;
          .name {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: aquamarine;
            text-align: center;
            line-height: 32px;
            color: #fff;
          }

          &::after {
            display: table;
            clear: both;
            content: "";
          }
        }
        .message {
          max-width: 332px;
          padding: 8px 12px;
          border: none;
          border-radius: 6px;
          -webkit-box-shadow: none;
          box-shadow: none;
          color: #fff;
          word-wrap: break-word;
          width: auto;
          position: relative;
          &::after {
            content: "";
            display: inline;
            position: absolute;
            border-style: solid;
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
            top: 10px;
          }
        }
      }
      .time {
        padding-top: 16px !important;

        color: #8c8c8c;
        position: relative;
        -webkit-animation: tap-data-v-6a28dce2 0.4s 1;
        animation: tap-data-v-6a28dce2 0.4s 1;
        will-change: animation;
        text-align: center;
      }
      .log {
        .avatar {
          float: left;
          .name {
            margin-right: 10px;
          }
        }
        .message {
          background-color: #e8e8e8;
          float: left;
          &::after {
            border-color: transparent #e8e8e8;
            left: -4px;
            border-width: 10px 10px 0 0;
          }
        }
      }
      .log-my {
        .avatar {
          float: right;
          .name {
            margin-left: 10px;
          }
        }
        .message {
          background-color: #1890ff;
          float: right;
          &::after {
            border-color: transparent #1890ff;
            right: -4px;
            border-width: 0 0 10px 10px;
          }
        }
      }
    }
    .footer {
      height: 91px;
      border-top: 1px solid #ededed;
      padding: 10px 20px 0 16px;
      .chatinput {
        display: inline-block;
        width: 100%;
        vertical-align: bottom;
        font-size: 14px;
        .textarea {
          outline: none;
          display: block;
          resize: none;
          min-height: 46px !important;
          padding: 0;
          line-height: 1.5;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
          width: 100%;
          font-size: inherit;
          color: #606266;
          background-color: #fff;
          background-image: none;
          border: 0;
          -webkit-transition: border-color 0.2s
            cubic-bezier(0.645, 0.045, 0.355, 1);
          transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
          font-size: 12px;
        }
      }
      .tools {
        height: 28px;
        line-height: 28px;
        .send {
          float: right;
          display: inline-block;
          line-height: 1;
          white-space: nowrap;
          cursor: pointer;
          background: #fff;
          border: 1px solid #dcdfe6;
          color: #606266;
          -webkit-appearance: none;
          text-align: center;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
          outline: 0;
          margin: 0;
          -webkit-transition: 0.1s;
          transition: 0.1s;
          font-weight: 500;
          padding: 7px 15px;
          font-size: 12px;
          border-radius: 4px;
        }
      }
    }
    .nochange {
      line-height: 460px;
      position: absolute;
      text-align: center;
      font-size: 12px;
      color: #606266;
      width: 100%;
      z-index: 1;
      .mark {
        width: 100%;
        height: 460px;
        position: absolute;
        background: rgba(255, 255, 255, 0.8);
        top: 0;
        z-index: -1;
      }
    }
  }
}
</style>
