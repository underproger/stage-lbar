import cv2, sys
sr = cv2.dnn_superres.DnnSuperResImpl_create()
sr.readModel('/home/claude/sr/EDSR_x2.pb'); sr.setModel('edsr', 2)
img = cv2.imread(sys.argv[1])
out = sr.upsample(img)
cv2.imwrite(sys.argv[2], out)
print(out.shape)
