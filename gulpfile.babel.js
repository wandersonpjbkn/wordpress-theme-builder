// Gulp 4.0
import gulp from 'gulp'
import mode from 'gulp-mode'

// modules internal
import { paths, tasks } from './builder/gulp'

const log = module => {
  const getHour = () => (() => { return new Date() })().toTimeString().split(' ')[0]
  const color = { cian: '\x1b[36m', gray: '\x1b[30m', white: '\x1b[0m' }
  const env = String(mode().production()).toUpperCase()

  console.log(
    `\n[${color.gray}${getHour()}${color.white}] `
      .concat(`Gulp '${color.cian}${module}${color.white}' (`)
      .concat(`process.env.NODE_ENV '${color.cian}production${color.white}' :: `)
      .concat(`${color.cian}${env}${color.white}`)
      .concat(')')
  )
}

// watcher
const watcher = () => {
  const sanitizeString = text => {
    const replace = string => string.replace(/\\/g, '/')
    const arr = []

    switch (typeof text) {
      case 'undefined':
        return

      case 'string':
        return replace(text)

      default:
        text.forEach(item => arr.push(replace(item)))
        return arr
    }
  }

  log('watcher')

  Object
    .keys(paths)
    .forEach(key => {
      const src = sanitizeString(paths[key].src)
      const watch = sanitizeString(paths[key].watch)

      if (tasks[key]) gulp.watch(src, tasks[key])
      if (paths[key].watch) gulp.watch(watch, tasks[key])
    })
}

// build current theme
const builder = done => {
  const excludeTasks = ['clean']

  // gets all tasks
  const _tasks = Object
    .values(tasks)
    .filter(fn => !excludeTasks.includes(fn.name)) // prevent double run of some tasks

  log('builder')

  // run tasks
  return gulp.series(tasks.clean, ..._tasks)(() => done())
}

// Exports
module.exports = {
  build: builder,
  watch: watcher,
  clean: tasks.clean
}
