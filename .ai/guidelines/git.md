=== git rules ===

## Git Commit Guidelines

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
git commit -m "Add user authentication routes"
git commit -m "Add login form component"
git commit -m "Update user model with auth methods"

# Bad - too many unrelated changes
git commit -m "Add auth, fix styles, update readme, refactor utils"
```

### Commit Order
1. Stage files for one feature or folder.
2. Commit with a short message.
3. Repeat for each group.

```bash
git add app/Models/User.php
git commit -m "Add email verification to User model"

git add resources/views/auth/
git commit -m "Add auth blade templates"

git add routes/web.php
git commit -m "Add auth routes"
```
