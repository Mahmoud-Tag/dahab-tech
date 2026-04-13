<template>
  <div ref="mountEl" class="scene-wrap"></div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import * as THREE from 'three'

const mountEl = ref(null)
let renderer, scene, camera, animId, resizeObserver

/* ─── Colour / material helpers ─── */
const GOLD       = 0xc9a227
const GOLD_LIGHT = 0xf0d060
const DARK       = 0x0a0a0a
const SCREEN_OFF = 0x0d1117
const SCREEN_ON  = 0x1a2a3a

function matGold(rough = 0.18) {
  return new THREE.MeshStandardMaterial({ color: GOLD, metalness: 1, roughness: rough })
}
function matDark(rough = 0.6) {
  return new THREE.MeshStandardMaterial({ color: DARK, metalness: 0.5, roughness: rough })
}
function matScreen(emissive = 0x0d2a4a) {
  return new THREE.MeshStandardMaterial({
    color: SCREEN_OFF,
    emissive: emissive,
    emissiveIntensity: 0.45,
    metalness: 0.1,
    roughness: 0.4,
  })
}

/* ─── Laptop builder ─── */
function buildLaptop() {
  const group = new THREE.Group()

  // Base body
  const base = new THREE.Mesh(
    new THREE.BoxGeometry(2.8, 0.18, 2),
    matDark()
  )
  base.position.y = 0
  group.add(base)

  // Gold edge trim on base
  const baseTrim = new THREE.Mesh(
    new THREE.BoxGeometry(2.84, 0.20, 2.04),
    matGold(0.25)
  )
  baseTrim.position.y = -0.01
  // Only the rim — use wireframe-like thin shell trick with scale
  baseTrim.scale.set(1, 0.3, 1)
  group.add(baseTrim)

  // Keyboard bed (slightly recessed)
  const kbd = new THREE.Mesh(
    new THREE.BoxGeometry(2.4, 0.02, 1.5),
    new THREE.MeshStandardMaterial({ color: 0x111111, metalness: 0.3, roughness: 0.8 })
  )
  kbd.position.set(0, 0.10, 0.1)
  group.add(kbd)

  // Trackpad
  const pad = new THREE.Mesh(
    new THREE.BoxGeometry(0.7, 0.015, 0.45),
    new THREE.MeshStandardMaterial({ color: 0x1a1a1a, metalness: 0.4, roughness: 0.5 })
  )
  pad.position.set(0, 0.105, 0.55)
  group.add(pad)

  // Lid (rotated ~100° open from base)
  const lid = new THREE.Group()
  lid.position.set(0, 0.09, -1.0)

  const lidBody = new THREE.Mesh(
    new THREE.BoxGeometry(2.8, 1.85, 0.14),
    matDark()
  )
  lidBody.position.set(0, 0.925, 0)
  lid.add(lidBody)

  // Gold border around lid
  const lidTrim = new THREE.Mesh(
    new THREE.BoxGeometry(2.84, 1.89, 0.12),
    matGold(0.22)
  )
  lidTrim.position.set(0, 0.925, 0.02)
  // Thin rim trick
  lidTrim.scale.set(1, 1, 0.18)
  lid.add(lidTrim)

  // Screen surface
  const screen = new THREE.Mesh(
    new THREE.BoxGeometry(2.55, 1.6, 0.01),
    matScreen(0x0d3060)
  )
  screen.position.set(0, 0.88, 0.075)
  lid.add(screen)

  // UI lines on screen (simulated dashboard)
  addScreenUI(lid, 0, 0.88, 0.08, 2.5, 1.55)

  // Hinge pivot — open at ~105°
  lid.rotation.x = -Math.PI * 0.58
  group.add(lid)

  // Apple-logo-like glow on back
  const logoGlow = new THREE.Mesh(
    new THREE.CircleGeometry(0.18, 16),
    new THREE.MeshStandardMaterial({ color: GOLD_LIGHT, emissive: GOLD_LIGHT, emissiveIntensity: 0.6 })
  )
  logoGlow.position.set(0, 1.78, -0.135)
  logoGlow.rotation.x = Math.PI * 0.42
  lid.rotation.x = -Math.PI * 0.58
  // re-add after fixing rotation
  const lidBack = new THREE.Group()
  lidBack.position.set(0, 0.09, -1.0)
  lidBack.rotation.x = -Math.PI * 0.58
  const logoMesh = new THREE.Mesh(
    new THREE.CircleGeometry(0.15, 16),
    new THREE.MeshStandardMaterial({ color: GOLD, emissive: GOLD, emissiveIntensity: 0.9 })
  )
  logoMesh.position.set(0, 0.92, -0.072)
  lidBack.add(logoMesh)
  group.add(lidBack)

  group.rotation.x = 0.18
  return group
}

/* ─── Phone builder ─── */
function buildPhone() {
  const group = new THREE.Group()

  // Body
  const body = new THREE.Mesh(
    new THREE.BoxGeometry(0.72, 1.48, 0.10),
    matDark(0.5)
  )
  group.add(body)

  // Gold frame
  const frame = new THREE.Mesh(
    new THREE.BoxGeometry(0.74, 1.50, 0.08),
    matGold(0.20)
  )
  frame.scale.set(1, 1, 0.35)
  group.add(frame)

  // Screen
  const screen = new THREE.Mesh(
    new THREE.BoxGeometry(0.62, 1.34, 0.01),
    matScreen(0x003050)
  )
  screen.position.set(0, 0, 0.056)
  group.add(screen)

  addScreenUI(group, 0, 0, 0.062, 0.6, 1.3)

  // Camera notch
  const notch = new THREE.Mesh(
    new THREE.CylinderGeometry(0.035, 0.035, 0.01, 12),
    matGold(0.3)
  )
  notch.rotation.x = Math.PI / 2
  notch.position.set(0, 0.66, 0.058)
  group.add(notch)

  return group
}

/* ─── Tablet builder ─── */
function buildTablet() {
  const group = new THREE.Group()

  // Body
  const body = new THREE.Mesh(
    new THREE.BoxGeometry(2.0, 1.42, 0.09),
    matDark(0.5)
  )
  group.add(body)

  // Gold frame
  const frame = new THREE.Mesh(
    new THREE.BoxGeometry(2.04, 1.46, 0.07),
    matGold(0.20)
  )
  frame.scale.set(1, 1, 0.3)
  group.add(frame)

  // Screen
  const screen = new THREE.Mesh(
    new THREE.BoxGeometry(1.84, 1.28, 0.01),
    matScreen(0x001a30)
  )
  screen.position.set(0, 0, 0.048)
  group.add(screen)

  addScreenUI(group, 0, 0, 0.053, 1.8, 1.24)

  // Home button
  const home = new THREE.Mesh(
    new THREE.CylinderGeometry(0.05, 0.05, 0.01, 16),
    matGold(0.25)
  )
  home.rotation.x = Math.PI / 2
  home.position.set(0.9, 0, 0.05)
  group.add(home)

  return group
}

/* ─── Screen UI decoration (glowing lines / bars) ─── */
function addScreenUI(parent, x, y, z, w, h) {
  const barMat = new THREE.MeshStandardMaterial({
    color: GOLD,
    emissive: GOLD,
    emissiveIntensity: 0.7,
  })
  const lineMat = new THREE.MeshStandardMaterial({
    color: 0x2a6090,
    emissive: 0x2a6090,
    emissiveIntensity: 0.5,
  })

  // Top header bar
  const header = new THREE.Mesh(new THREE.BoxGeometry(w * 0.9, h * 0.06, 0.001), barMat.clone())
  header.material.emissiveIntensity = 0.5
  header.position.set(x, y + h * 0.42, z)
  parent.add(header)

  // A few horizontal data lines
  const lineHeights = [0.22, 0.08, -0.06, -0.20, -0.34]
  lineHeights.forEach((lh, i) => {
    const lw = (0.5 + Math.random() * 0.35) * w
    const bar = new THREE.Mesh(new THREE.BoxGeometry(lw, h * 0.025, 0.001), lineMat.clone())
    bar.material.emissiveIntensity = 0.3 + i * 0.05
    bar.position.set(x - (w * 0.45 - lw / 2), y + lh * h * 0.5, z)
    parent.add(bar)
  })

  // Pie chart–like circle (ring)
  const ring = new THREE.Mesh(
    new THREE.TorusGeometry(h * 0.12, h * 0.025, 8, 24),
    new THREE.MeshStandardMaterial({ color: GOLD, emissive: GOLD, emissiveIntensity: 0.8 })
  )
  ring.position.set(x + w * 0.3, y - h * 0.22, z)
  parent.add(ring)
}

/* ─── Scene setup ─── */
function init(container) {
  const W = container.clientWidth
  const H = container.clientHeight

  // Renderer
  renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true })
  renderer.setSize(W, H)
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))
  renderer.setClearColor(0x000000, 0) // transparent
  container.appendChild(renderer.domElement)

  // Scene
  scene = new THREE.Scene()

  // Camera
  camera = new THREE.PerspectiveCamera(38, W / H, 0.1, 100)
  camera.position.set(0, 1.2, 10.5)
  camera.lookAt(0, 0, 0)

  // Lights
  const ambient = new THREE.AmbientLight(0xffffff, 0.80)
  scene.add(ambient)

  // Main gold key light (top-front-right)
  const keyLight = new THREE.PointLight(GOLD, 7.0, 35)
  keyLight.position.set(3, 5, 5)
  scene.add(keyLight)

  // Top-left fill (warm)
  const topFill = new THREE.PointLight(0xffeebb, 3.0, 25)
  topFill.position.set(-4, 4, 5)
  scene.add(topFill)

  const fillLight = new THREE.PointLight(0xffd070, 2.0, 22)
  fillLight.position.set(-4, 2, 3)
  scene.add(fillLight)

  // Blue rim from behind
  const rimLight = new THREE.PointLight(0x2060c0, 1.5, 18)
  rimLight.position.set(0, -1, -6)
  scene.add(rimLight)

  // Screen bounce glow
  const screenLight = new THREE.PointLight(0x204080, 1.5, 10)
  screenLight.position.set(0, 0.5, 3)
  scene.add(screenLight)

  // ── Build device GROUP ──
  const group = new THREE.Group()

  // Laptop — centre-back, slightly angled
  const laptop = buildLaptop()
  laptop.position.set(-0.1, 0.3, -0.2)
  laptop.rotation.y = -0.15
  group.add(laptop)

  // Phone — right side, standing upright, angled
  const phone = buildPhone()
  phone.position.set(2.0, -0.1, 0.6)
  phone.rotation.y = -0.5
  phone.rotation.x = -0.05
  group.add(phone)

  // Tablet — front-left, lying slightly tilted
  const tablet = buildTablet()
  tablet.position.set(-1.6, -0.8, 1.2)
  tablet.rotation.x = -0.4
  tablet.rotation.y = 0.28
  group.add(tablet)

  // Scale group down to fit viewport, add slight overall tilt
  group.scale.setScalar(0.72)
  group.rotation.x = 0.10
  group.position.y = 0.3   // raise to center in canvas
  scene.add(group)

  // ── Add a subtle reflective plane under devices ──
  const plane = new THREE.Mesh(
    new THREE.PlaneGeometry(12, 12),
    new THREE.MeshStandardMaterial({
      color: 0x080808,
      metalness: 0.9,
      roughness: 0.15,
      transparent: true,
      opacity: 0.6,
    })
  )
  plane.rotation.x = -Math.PI / 2
  plane.position.y = -1.35
  scene.add(plane)

  // ── Particle field (golden dots) ──
  const particleGeo = new THREE.BufferGeometry()
  const count = 300
  const pos = new Float32Array(count * 3)
  for (let i = 0; i < count; i++) {
    pos[i * 3]     = (Math.random() - 0.5) * 14
    pos[i * 3 + 1] = (Math.random() - 0.5) * 10
    pos[i * 3 + 2] = (Math.random() - 0.5) * 10 - 2
  }
  particleGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3))
  const particles = new THREE.Points(
    particleGeo,
    new THREE.PointsMaterial({ color: GOLD, size: 0.025, transparent: true, opacity: 0.55 })
  )
  scene.add(particles)

  // ── Animate ──
  let t = 0
  function tick() {
    animId = requestAnimationFrame(tick)
    t += 0.008

    // Gentle Y rotation of whole group
    group.rotation.y = Math.sin(t * 0.4) * 0.35

    // Float up/down
    group.position.y = Math.sin(t * 0.6) * 0.15

    // Individual subtle wobbles
    laptop.rotation.z = Math.sin(t * 0.5 + 1) * 0.018
    phone.rotation.z  = Math.sin(t * 0.7 + 2) * 0.025
    tablet.rotation.z = Math.sin(t * 0.4 + 0.5) * 0.02

    // Particles slow drift
    particles.rotation.y += 0.0012

    renderer.render(scene, camera)
  }
  tick()

  // ── Resize observer ──
  resizeObserver = new ResizeObserver(() => {
    const w = container.clientWidth
    const h = container.clientHeight
    renderer.setSize(w, h)
    camera.aspect = w / h
    camera.updateProjectionMatrix()
  })
  resizeObserver.observe(container)
}

onMounted(() => {
  if (mountEl.value) init(mountEl.value)
})

onUnmounted(() => {
  cancelAnimationFrame(animId)
  resizeObserver?.disconnect()
  renderer?.dispose()
})
</script>

<style scoped>
.scene-wrap {
  width: 100%;
  height: 520px;
  position: relative;
}

@media (max-width: 900px) {
  .scene-wrap { height: 340px; }
}
</style>
