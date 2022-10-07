<p align="center">
    <a href="https://alphpaca.io" target="_blank">
        <img src="https://github.com/alphpaca/.github/blob/main/banners/monoplus-split-action.png?raw=true" />
    </a>
</p>

# Monoplus Split Action

Monoplus Split Action is highly inspired by [GitHub Action for Monorepo Split](https://github.com/symplify/monorepo-split-github-action) created by [Tomas Votruba](https://github.com/TomasVotruba).
The idea to create this tool has born while creating a monorepo project. Monoplus Split Action is a mix of `GitHub Action for Monorepo Split`, needs discovered while creating monorepo for [Sylius Plus](https://sylius.com/plus/) and my approach to writing code.

## 🔑 Key features

The idea is not complicated - you have a monorepo and you want to split it into multiple repositories, so there aren't too many differences in a way how it works. However, there are some differences in the way how it is implemented.

👉🏼 Usage of Symfony's components  
👉🏼 Unit tested code  
👉🏼 While splitting the original history of commits is preserved (for the scope of the split package)

**The most important feature is the last one.** Instead of taking all changes and commit them within a single commit we select those commit which are related to the split package. This way we preserve the original history of commits every time (so we reflect any changed made via `git rebase` too).

## ⚙️ How to use

```yaml
# ...
jobs:
    # ...
    steps:
        # ...
        
        # when no "tag" is set then changes are pushed
        -
            if: "!startsWith(github.ref, 'refs/tags/')"
            name: "Split (No Tag)"
            uses: "alphpaca/monoplus-split-action@2022.1"
            with:
                package_path: 'path/to/your/package' #required
                ssh_private_key: ${{ secrets.PACKAGE_DEPLOY_KEY }} # required
                git_username: 'jakubtobiasz' # required
                git_email: 'jakub@alphpaca.io' # required
                repository_host: 'github.com' # "github.com" is a default value, there is no need to set it explicitly
                repository_owner: "jakubtobiasz" # required
                repository_name: "monoplus-split-dummy" # required
                target_branch: "main" # "main" is a default value, there is no need to set it explicitly

        # when "tag" is set then no changes are pushed, only tag
        -
            if: "startsWith(github.ref, 'refs/tags/')"
            name: Extract tag
            id: extract_tag
            run: echo ::set-output name=TAG::${GITHUB_REF/refs\/tags\//}
        
        -
            if: "startsWith(github.ref, 'refs/tags/')"
            name: "Split (Tag)"
            uses: "alphpaca/monoplus-split-action@2022.1"
            with:
                package_path: 'path/to/your/package' #required
                ssh_private_key: ${{ secrets.PACKAGE_DEPLOY_KEY }} # required
                git_username: 'jakubtobiasz' # required
                git_email: 'jakub@alphpaca.io' # required
                repository_host: 'github.com' # "github.com" is a default value, there is no need to set it explicitly
                repository_owner: "jakubtobiasz" # required
                repository_name: "monoplus-split-dummy" # required
                target_branch: "main" # "main" is a default value, there is no need to set it explicitly
                tag: ${{ steps.extract_tag.outputs.TAG }} # optional, used only when we want to tag a new version
```

`PACKAGE_DEPLOY_KEY` can be both standard SSH associated with GitHub account, but also a GitHub deploy key can be used, what is recommended by us.

## 👋🏼 About Alphpaca

**Alphpaca** (pronounced /ˈælphəkə/) is a software house based in Poland. We are a team of experienced developers who are passionate about open source and e-commerce. We are the creators of tools making developer's life easier and plugins for the [Sylius e-commerce platform](https://sylius.com).

<table>
    <thead>
        <tr>
            <th width="1000px">Tools</th>
            <th width="1000px">Standard plugins</th>
            <th width="1000px">Headless plugins</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><p align="center"><img src="https://github.com/alphpaca/.github/blob/main/badge/tool-badge.png?raw=true" alt="Alphpaca tool badge"></p></td>
            <td><p align="center"><img src="https://github.com/alphpaca/.github/blob/main/badge/admin-plugin-badge.png?raw=true" alt="Alphpaca tool badge" /></p></td>
            <td><p align="center"><img src="https://github.com/alphpaca/.github/blob/main/badge/headless-plugin-badge.png?raw=true" alt="Alphpaca tool badge" /></p></td>
        </tr>
        <tr>
            <td>
                <p align="center">
                    <a href="https://github.com/alphpaca/monoplus-split-action">Monoplus Split Action</a><br/>
                </p>
                Split your monorepo preserving the original commit history
            </td>
            <td>
                <p align="center">
                    <a href="https://github.com/alphpaca/sylius-permissions-plugin">Permissions plugin</a>
                </p>
                Add and manage permissions across your Sylius Admin Panel
            </td>
            <td>
                We are actively working on expanding our portfolio of open-sourced plugins. Stay tuned!
            </td>
        </tr>
    </tbody>
</table>
