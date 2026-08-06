import sys

filepath = sys.argv[1]
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

old = "url('{{ '/storage/'. }}')"
new = "url('{{ '/storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg') }}')"
content = content.replace(old, new)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print('Done: ' + filepath)
