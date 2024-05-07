# ms-tts

A PHP wrapper for the Microsoft Azure TTS API

## Usage

The POST method is used to submit XML or JSON data.

### XML

Standard Microsoft Azure TTS XML data is accepted.

For example:

```
curl -X POST 'https://example.com/ms-tts/?type=xml' -d '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:mstts="https://www.w3.org/2001/mstts" xml:lang="zh-CN">
    <voice name="zh-CN-XiaomoNeural">
        <mstts:express-as style="sad" styledegree="2">
            快走吧，路上一定要注意安全，早去早回。
        </mstts:express-as>
    </voice>
</speak>
'
```

### JSON

accepts three JSON data formats:

**1. Default Voice (zh-CN-XiaoxiaoNeural)**

To use the default voice (zh-CN-XiaoxiaoNeural), provide a string enclosed in quotation marks.

Example:

```
curl -X POST 'https://example.com/ms-tts/?type=json' -d '"你好，我是晓晓"'
```

**2. Specifying a Voice**

To specify a different voice, provide an array with two or mmore elements: the voice name as the first element and the text to be read as the later element.

Example:

```
curl -X POST 'https://example.com/ms-tts/?type=json' -d '["zh-CN-XiaomoNeural", "你好，我是小莫"]'
```

**3. Specifying Multiple Voices**

To have a single piece of text read by multiple voices, construct an array containing two or more array-type elements, each following the format defined in **2**.

Example:

```
curl -X POST 'https://example.com/ms-tts/?type=json' -d '[["zh-CN-XiaomoNeural", "你好，我是小莫"],["zh-CN-XiaoxiaoNeural", "你好，我是小小"]]'
```

## Special Usage

To be continued...