import math
import numpy as np
import matplotlib.pyplot as plt
from matplotlib.animation import FuncAnimation
from rplidar import RPLidar

# ----------------------------
# CHANGE THIS TO YOUR PORT
# ----------------------------
PORT = "/dev/ttyUSB0"
# PORT = "COM3"       # Windows

lidar = RPLidar(PORT)

fig, ax = plt.subplots(figsize=(8, 8))

scatter = ax.scatter([], [], s=2)

ax.set_xlim(-6000, 6000)
ax.set_ylim(-6000, 6000)

ax.set_aspect('equal')
ax.grid(True)

ax.set_title("RPLIDAR A1M8 Live Scan")
ax.set_xlabel("X (mm)")
ax.set_ylabel("Y (mm)")

scan_iterator = lidar.iter_scans(max_buf_meas=2000)


def update(frame):
    scan = next(scan_iterator)

    xs = []
    ys = []

    for (_, angle, distance) in scan:

        if distance == 0:
            continue

        theta = math.radians(angle)

        x = distance * math.cos(theta)
        y = distance * math.sin(theta)

        xs.append(x)
        ys.append(y)

    scatter.set_offsets(np.c_[xs, ys])

    return scatter,


ani = FuncAnimation(fig, update, interval=20, blit=True)

try:
    plt.show()

finally:
    print("Stopping lidar...")
    lidar.stop()
    lidar.disconnect()