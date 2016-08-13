require 'middleman-gh-pages'
require 'fileutils'

task :default => [:build]

task :apigen do
  source = 'tmp/xu'
  target = 'docs'

  if Dir.exists?(source)
    FileUtils.remove_dir(source)
  end

  if Dir.exists?(target)
    FileUtils.remove_dir(target)
  end

  sh "git clone git@github.com:frozzare/wp-xu.git #{source}"
  sh "cd #{source}"
  sh "apigen generate --groups=none -s #{source}/src -d #{target}"

  FileUtils.remove_dir(source)

  sh "git add ."
  sh "git commit -m 'Update apigen docs'"
  sh "git push origin gh-pages"
end
