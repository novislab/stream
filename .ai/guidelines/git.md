=== git rules ===

## Git Commit Guidelines

### Pre-Commit
- Run `composer run format` before committing to ensure code style consistency.

### Commit Strategy
- Group related changes by file, folder, or feature.
- Commit each group separately, one by one.
- Do not bundle unrelated changes into a single commit.

### Commit Messages
- Keep messages simple and short (50 characters or less).
- Use imperative mood: "Add", "Fix", "Update", "Remove".
- Do not include AI co-author or attribution in commits.

### Examples

```bash
# Good - grouped by feature/folder
composer run format
git commit -m "Add user authentication routes"
git commit -m "Add login form component"
git commit -m "Update user model with auth methods"

# Bad - too many unrelated changes
git commit -m "Add auth, fix styles, update readme, refactor utils"
```

### Commit Order
1. Run `composer run format`.
2. Stage files for one feature or folder.
3. Commit with a short message.
4. Repeat for each group.

```bash
composer run format
git add app/Models/User.php
git commit -m "Add email verification to User model"

git add resources/views/auth/
git commit -m "Add auth blade templates"

git add routes/web.php
git commit -m "Add auth routes"
```
