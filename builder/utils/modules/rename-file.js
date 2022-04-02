import Stream from 'stream'
import Path from 'path'

const gulpRename = params => {
  // return the path data as an object
  const getFileRelativePathAsObject = path => ({
    dirname: Path.dirname(path),
    basename: Path.basename(path, Path.extname(path)),
    extname: Path.extname(path)
  })

  // return a string
  const newFileName = ({ params, obj, file }) => {
    // get file path as object
    const parsedPath = getFileRelativePathAsObject(file.relative)

    let extname = ''

    // set obj pre and suffix properties
    obj.prefix = params.prefix || ''
    obj.suffix = params.suffix || ''

    // set obj basename when string was passed
    if (typeof params === 'string') {
      obj.dirname = parsedPath.dirname
      obj.basename = params
      obj.extname = parsedPath.extname

    // set obj properties and passed object or function
    } else {
      const newParsedPath = typeof params === 'function'
        ? params(parsedPath, file)
        : params

      Object
        .keys(obj)
        .forEach(key => {
          // block overwriten of prefix and suffix
          if (['prefix', 'suffix'].includes(key)) return

          // save relative new value to obj
          obj[key] = key in newParsedPath
            ? newParsedPath[key]
            : parsedPath[key]
        })
    }

    // fix dot in extname
    extname = ~obj.extname.indexOf('.')
      ? `${obj.extname}`
      : `.${obj.extname}`

    // return new file, path and properties
    return Path.join(obj.dirname, `${obj.prefix}${obj.basename}${obj.suffix}${extname}`)
  }

  // set stream
  const stream = new Stream.Transform({ objectMode: true })

  // set an object to hold the new file properties
  const newName = { dirname: '', prefix: '', suffix: '', basename: '', extname: '' }

  // start validation
  stream._transform = (originalFile, unused, callback) => {
    const file = originalFile.clone({ contents: false })

    // return error if any valid type was passed as params
    if (!['string', 'function', 'object'].includes(typeof params)) {
      return callback(new Error('Unsupported renaming parameter type supplied\n\r'), undefined)
    }

    // set the new file properties
    file.path = Path.join(
      file.base,
      newFileName({ params: params, obj: newName, file: file })
    )

    // callback to stream transform
    callback(null, file)
  }

  // end
  return stream
}

export {
  gulpRename
}
