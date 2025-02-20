git status
git add com
git commit -m "se guardaron los comandos git" 
git push
javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (master)
$ git status
On branch master
nothing to commit, working tree clean

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (master)
$ git remote add origin https://github.com/Javi32012/muebleria1.0.git

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (master)
$ git status
On branch master
nothing to commit, working tree clean

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (master)
$ git branch -M master

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (master)
$ git status
On branch master
nothing to commit, working tree clean

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (master)
$ git branch -M main

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git push -u origin main
Enumerating objects: 17, done.
Counting objects: 100% (17/17), done.
Delta compression using up to 12 threads
Compressing objects: 100% (14/14), done.
Writing objects: 100% (17/17), 1.92 KiB | 983.00 KiB/s, done.
Total 17 (delta 2), reused 0 (delta 0), pack-reused 0 (from 0)
remote: Resolving deltas: 100% (2/2), done.
To https://github.com/Javi32012/muebleria1.0.git
 * [new branch]      main -> main
branch 'main' set up to track 'origin/main'.

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git status
On branch main
Your branch is up to date with 'origin/main'.

nothing to commit, working tree clean

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ code .

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git status
On branch main
Your branch is up to date with 'origin/main'.

Untracked files:
  (use "git add <file>..." to include in what will be committed)
        com

nothing added to commit but untracked files present (use "git add" to track)

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ ^C

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git add com

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        new file:   com


javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git commit -m "se guardaron los comandos git"ç                                [main c2345d2] se guardaron los comandos gitç
 1 file changed, 0 insertions(+), 0 deletions(-)
 create mode 100644 com

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git status
On branch main
Your branch is ahead of 'origin/main' by 1 commit.
  (use "git push" to publish your local commits)

nothing to commit, working tree clean

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git push
Enumerating objects: 3, done.
Counting objects: 100% (3/3), done.
Delta compression using up to 12 threads
Compressing objects: 100% (2/2), done.
Writing objects: 100% (2/2), 258 bytes | 258.00 KiB/s, done.
Total 2 (delta 1), reused 0 (delta 0), pack-reused 0 (from 0)
remote: Resolving deltas: 100% (1/1), completed with 1 local object.
To https://github.com/Javi32012/muebleria1.0.git
   4fb0d96..c2345d2  main -> main

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git status
On branch main
Your branch is up to date with 'origin/main'.

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   com

no changes added to commit (use "git add" and/or "git commit -a")

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git add com

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git commit -m "se guardaron los comandos git"ç
[main 686bf49] se guardaron los comandos gitç
 1 file changed, 3 insertions(+)

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git push
Enumerating objects: 5, done.
Counting objects: 100% (5/5), done.
Delta compression using up to 12 threads
Compressing objects: 100% (3/3), done.
Writing objects: 100% (3/3), 335 bytes | 335.00 KiB/s, done.
Total 3 (delta 1), reused 0 (delta 0), pack-reused 0 (from 0)
remote: Resolving deltas: 100% (1/1), completed with 1 local object.
To https://github.com/Javi32012/muebleria1.0.git
   c2345d2..686bf49  main -> main

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$ git status
On branch main
Your branch is up to date with 'origin/main'.

nothing to commit, working tree clean

javie@Javier MINGW64 /c/xampp/htdocs/HTML/Muebleria1.0 (main)
$